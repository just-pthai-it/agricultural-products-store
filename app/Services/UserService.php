<?php

namespace App\Services;

use App\Http\Resources\ProductCartResource;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\ProductBatchRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService implements Contracts\UserServiceContract
{
    private UserRepositoryContract $userRepository;
    private ProductBatchRepositoryContract $productBatchRepository;

    /**
     * @param UserRepositoryContract         $userRepository
     * @param ProductBatchRepositoryContract $productBatchRepository
     */
    public function __construct (UserRepositoryContract         $userRepository,
                                 ProductBatchRepositoryContract $productBatchRepository)
    {
        $this->userRepository         = $userRepository;
        $this->productBatchRepository = $productBatchRepository;
    }

    public function readManyProductCarts (string $userId) : AnonymousResourceCollection
    {
        $products = $this->userRepository->findProductCartsByUserId($userId);
        return ProductCartResource::collection($products);
    }

    public function updateProductCartQuantity (string $userId, string $productId, array $inputs)
    {
        $productQuantity = $this->_readProductQuantityByProductId($productId);
        if ($this->_checkIfInputQuantityIsValid($inputs['quantity'], $productQuantity))
        {
            $this->userRepository->updateProductCartQuantityByUserIdAndProductId($userId, $productId,
                                                                                 $inputs);
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
}