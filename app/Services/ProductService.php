<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Repositories\Contracts\ProductRepositoryContract;

class ProductService implements Contracts\ProductServiceContract
{
    private ProductRepositoryContract $productDepository;

    /**
     * @param ProductRepositoryContract $productDepository
     */
    public function __construct (ProductRepositoryContract $productDepository)
    {
        $this->productDepository = $productDepository;
    }

    public function read (string $productId, array $inputs)
    {
        $product = $this->productDepository->find(['*'], [['id', '=', $productId]], [], [],
                                                  [['filter', $inputs], ['with', 'productBatches', 'productUnit', 'productDetailImages']])[0];

        return new ProductResource($product);
    }
}