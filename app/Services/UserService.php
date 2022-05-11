<?php

namespace App\Services;

use App\Http\Resources\ProductCartResource;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService implements Contracts\UserServiceContract
{
    private UserRepositoryContract $userDepository;

    /**
     * @param UserRepositoryContract $userDepository
     */
    public function __construct (UserRepositoryContract $userDepository)
    {
        $this->userDepository = $userDepository;
    }

    public function readManyProductCarts (string $userId) : AnonymousResourceCollection
    {
        $products = $this->userDepository->findProductCartsByUserId($userId);
        return ProductCartResource::collection($products);
    }
}