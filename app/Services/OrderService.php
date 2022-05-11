<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderService implements Contracts\OrderServiceContract
{
    private OrderRepositoryContract $orderDepository;

    /**
     * @param OrderRepositoryContract $orderDepository
     */
    public function __construct (OrderRepositoryContract $orderDepository)
    {
        $this->orderDepository = $orderDepository;
    }

    public function readManyByUserId (string $userId, array $inputs) : AnonymousResourceCollection
    {
        $orders = $this->orderDepository->find(['*'], [['user_id', '=', $userId]], [], [],
                                               [['filter', $inputs]]);
        return OrderResource::collection($orders);
    }
}