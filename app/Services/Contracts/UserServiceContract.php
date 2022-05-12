<?php

namespace App\Services\Contracts;

interface UserServiceContract
{
    public function readManyProductCarts (string $userId);

    public function updateProductCartQuantity (string $userId, array $inputs);
}