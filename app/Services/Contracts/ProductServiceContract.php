<?php

namespace App\Services\Contracts;

interface ProductServiceContract
{
    public function read(string $productId, array $inputs);
}