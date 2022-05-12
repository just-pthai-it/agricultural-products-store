<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract extends BaseRepositoryContract
{
    public function findProductCartsByUserId (string $userId);

    public function updateProductCartQuantityByUserId (string $userId, array $inputs);
}