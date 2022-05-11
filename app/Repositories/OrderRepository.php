<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Abstracts\BaseRepository;

class OrderRepository extends BaseRepository implements Contracts\OrderRepositoryContract
{
    function model () : string
    {
        return Order::class;
    }
}