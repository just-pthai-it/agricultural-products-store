<?php

namespace App\Services\Contracts;

interface UserServiceContract
{
    public function readManyProductCarts (string $userId);
}