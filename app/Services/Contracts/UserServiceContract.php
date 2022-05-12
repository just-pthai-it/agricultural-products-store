<?php

namespace App\Services\Contracts;

interface UserServiceContract
{
    public function readManyProductCarts (string $userId);

    public function updateProductCartQuantity (string $userId, string $productId, array $inputs);

    public function storeProductCart (string $userId, string $productId, array $inputs);

    public function deleteProductCart (string $userId, string $productId);
}