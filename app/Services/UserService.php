<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Resources\ProductCartResource;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Contracts\ProductBatchRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService implements Contracts\UserServiceContract
{
    private UserRepositoryContract $userRepository;
    private ProductBatchRepositoryContract $productBatchRepository;
    private ProductRepositoryContract $productRepository;
    private OrderRepositoryContract $orderRepository;

    private const TRANSACTION_ERROR_CODE = 509;

    /**
     * @param UserRepositoryContract         $userRepository
     * @param ProductBatchRepositoryContract $productBatchRepository
     * @param ProductRepositoryContract      $productRepository
     * @param OrderRepositoryContract        $orderRepository
     */
    public function __construct (UserRepositoryContract         $userRepository,
                                 ProductBatchRepositoryContract $productBatchRepository,
                                 ProductRepositoryContract      $productRepository,
                                 OrderRepositoryContract        $orderRepository)
    {
        $this->userRepository         = $userRepository;
        $this->productBatchRepository = $productBatchRepository;
        $this->productRepository      = $productRepository;
        $this->orderRepository        = $orderRepository;
    }

    public function readManyProductCarts (string $userId) : AnonymousResourceCollection
    {
        $productsCart = $this->userRepository->findProductCartsByUserId($userId);
        $this->_updateProductsCartQuantity($productsCart);
        return ProductCartResource::collection($productsCart);
    }

    private function _updateProductsCartQuantity (Collection $productsCart)
    {
        foreach ($productsCart as $productCart)
        {
            if ($productCart->pivot->quantity > $productCart->productBatches[0]->quantity)
            {
                $productCart->pivot->quantity = $productCart->productBatches[0]->quantity;
                $productCart->pivot->save();
            }
        }
    }

    public function updateProductCartQuantity (string $userId, string $productId, array $inputs)
    {
        $productQuantity = $this->_readProductQuantityByProductId($productId);
        if ($this->_checkIfInputQuantityIsValid($inputs['quantity'], $productQuantity))
        {
            $this->userRepository->updateExistingPivot($userId, [$productId],
                                                       'carts', $inputs);
            return response('', 200);
        }
        else
        {
            return response(['message' => 'Quantity is invalid',
                             'data'    => ['maxQuantity' => $productQuantity]],
                            406);
        }
    }

    private function _readProductQuantityByProductId (string $productId)
    {
        return $this->productBatchRepository->find(['quantity'],
                                                   [['product_id', '=', $productId]])[0]->quantity;
    }

    private function _checkIfInputQuantityIsValid (int $inputsQuantity, int $quantity) : bool
    {
        return $inputsQuantity <= $quantity;
    }

    public function createProductCart (string $userId, string $productId, array $inputs)
    {
        if ($this->_checkIfProductPivotExists($userId, $productId))
        {
            return $this->_updateExistingProductCart($userId, $productId, $inputs);
        }

        return $this->_createProductCart($userId, $productId, $inputs);
    }

    private function _updateExistingProductCart (string $userId, string $productId, array $inputs)
    {
        $this->userRepository->updateExistingPivot($userId, [$productId], 'carts',
                                                   ['quantity' => DB::raw("quantity + {$inputs['quantity']}")]);
        return response('', 200);
    }

    private function _createProductCart (string $userId, string $productId, array $inputs)
    {
        $this->userRepository->insertPivot($userId, [$productId => $inputs], 'carts');
        return response('', 201);
    }

    private function _checkIfProductPivotExists (string $userid, string $productId)
    {
        return $this->userRepository->checkIfPivotExist($userid, [$productId], 'carts',
                                                        'product_id');
    }

    public function deleteProductCart (string $userId, string $productId)
    {
        $this->userRepository->deletePivot($userId, [$productId], 'carts');
    }

    public function checkout (string $userId, array $inputs)
    {
        $errors = $this->_transaction($userId, $inputs);
        if (empty($errors))
        {
            return response('', 200);
        }

        if ($errors[0] == self::TRANSACTION_ERROR_CODE)
        {
            return response(['errors' => ['Can not execute transaction']],
                            self::TRANSACTION_ERROR_CODE);
        }

        return response(['errors' => $errors], 409);
    }

    private function _transaction (string $userId, array $inputs) : array
    {
        $errors       = [];
        $products     = $this->_readProductsByProductIds($inputs['product_ids']);
        $productsCart = $this->_readProductsCartByUserIdAndProductIds($userId,
                                                                      $inputs['product_ids']);

        if (count($inputs['product_ids']) != $products->count() ||
            count($inputs['product_ids']) != $productsCart->count() ||
            $productsCart->count() != $productsCart->count())
        {
            return [self::TRANSACTION_ERROR_CODE];
        }

        DB::transaction(function () use ($userId, $inputs, $products, $productsCart, &$errors)
        {
            if ($this->_updateProductsQuantity($inputs['product_ids'], $productsCart, $products))
            {
                $total = $this->_calculateTotal($inputs['product_ids'], $products, $productsCart);
                if ($total != -1)
                {
                    $orderId = $this->_createOrder($userId, $total);
                    $this->_createOrderProduct($orderId, $productsCart);
                    $this->_deleteProductsCart($userId, $inputs['product_ids']);
                }
                else
                {
                    $errors[] = 'Product price has been updated';
                    DB::rollBack();
                }
            }
            else
            {
                $errors[] = 'Product quantity has been updated';
                DB::rollBack();
            }
            DB::rollBack();

        });

        return $errors;
    }

    private function _readProductsCartByUserIdAndProductIds (string $userId, array $productIds)
    {
        return $this->userRepository->findProductCartsByUserIdAndProductIds($userId, $productIds);
    }

    private function _readProductsByProductIds (array $productIds)
    {
        return $this->productRepository->find(['*'], [['id', 'in', $productIds]], [], [],
                                              [['with', ['productBatches']]]);
    }

    private function _updateProductsQuantity (array      $productIds, Collection $productsCart,
                                              Collection $products) : bool
    {
        foreach ($productIds as $productId)
        {
            //            var_dump($productId);
            //            echo json_encode($products->where('id', '=', $productId));
            //            var_dump($products->count());
            //            $product     = $products->where('id', '=', $productId)[0];
            //            $productCart = $productsCart->where('id', '=', $productId)[0];

            //            var_dump($productId);
            //            echo json_encode($products->where('id', '=', $productId));
            //            var_dump($products->count());
            $product     = $products->firstWhere('id', '=', $productId);
            $productCart = $productsCart->firstWhere('id', '=', $productId);
            if ($product->productBatches[0]->quantity - $productCart->pivot->quantity >= 0)
            {
                $product->productBatches[0]->quantity -= $productCart->pivot->quantity;
                $product->productBatches[0]->save();
            }
            else
            {
                return false;
            }
        }

        return true;
    }

    private function _calculateTotal (array $productIds, $products, Collection $productsCart)
    {
        $total = 0;
        foreach ($productIds as $productId)
        {
            $product     = $products->firstWhere('id', '=', $productId);
            $productCart = $productsCart->firstWhere('id', '=', $productId);
            //            if ($product->price == $productCart->price)
            //            {
            $total += $product->price * $productCart->pivot->quantity;
            //            }
            //            else
            //            {
            //                return -1;
            //            }
        }

        return $total;
    }

    private function _createOrder (string $userId, float $total)
    {
        return $this->orderRepository->insertGetId(['user_id' => $userId, 'total' => $total]);
    }

    private function _createOrderProduct (string $orderId, Collection $productsCart)
    {
        $values = [];
        foreach ($productsCart as $productCart)
        {
            if ($productCart->pivot->quantity != 0)
            {
                $values[$productCart->id] = ['price'    => $productCart->price,
                                             'quantity' => $productCart->pivot->quantity];
            }
        }
        $this->orderRepository->insertPivot($orderId, $values, 'products');
    }

    private function _deleteProductsCart (string $userId, array $productIds)
    {
        $this->userRepository->deletePivot($userId, $productIds, 'carts');
    }
}