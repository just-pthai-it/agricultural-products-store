<?php

namespace App\Services\Contracts;

interface ProductServiceContract
{
    public function read (string $productId, array $inputs);

    public function readMany (array $inputs);

    public function readManyByCategoryId (string $categoryId, array $inputs);
}