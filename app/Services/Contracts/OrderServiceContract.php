<?php

namespace App\Services\Contracts;

interface OrderServiceContract
{
    public function readManyByUserId (string $userId, array $inputs);
}