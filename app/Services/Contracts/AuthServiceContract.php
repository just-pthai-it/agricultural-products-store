<?php

namespace App\Services\Contracts;

interface AuthServiceContract
{
    public function register (array $inputs);

    public function login (array $inputs);

    public function logout (string $options);

    public function verifyAccount (array $inputs);
}