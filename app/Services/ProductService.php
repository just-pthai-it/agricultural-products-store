<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductService implements Contracts\ProductServiceContract
{
    private ProductRepositoryContract $productRepository;

    /**
     * @param ProductRepositoryContract $productRepository
     */
    public function __construct (ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function read (string $productId, array $inputs) : ProductResource
    {
        $product = $this->productRepository->find(['*'], [['id', '=', $productId]], [], [],
                                                  [['filter', $inputs], ['with', 'productBatches', 'productUnit', 'productRetailImages']])[0];

        return new ProductResource($product);
    }

    public function readMany (array $inputs) : AnonymousResourceCollection
    {
        $products = $this->productRepository->find(['*'], [], [], [], [['filter', $inputs]]);
        return ProductResource::collection($products);
    }

    public function readManyByCategoryId (string $categoryId,
                                          array  $inputs) : AnonymousResourceCollection
    {
        $products = $this->productRepository->find(['*'], [['category_id', '=', $categoryId]], [],
                                                   [], [['filter', $inputs]]);
        return ProductResource::collection($products);
    }
}