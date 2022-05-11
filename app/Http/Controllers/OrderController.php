<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\OrderServiceContract;

class OrderController extends Controller
{
    private OrderServiceContract $orderService;

    /**
     * @param OrderServiceContract $orderService
     */
    public function __construct (OrderServiceContract $orderService)
    {
        $this->orderService = $orderService;
    }

    public function readManyByUserId (Request $request, string $userId)
    {
        return $this->orderService->readManyByUserId($userId, $request->all());
    }
}
