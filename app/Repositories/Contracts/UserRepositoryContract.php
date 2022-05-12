<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract extends BaseRepositoryContract
{
    public function findProductCartsByUserId (string $userId);

    public function updateProductCartQuantityByUserIdAndProductId (string $userId,
                                                                   string $productId, array $inputs);
}