<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Abstracts\BaseRepository;

class ProductRepository extends BaseRepository implements Contracts\ProductRepositoryContract
{
    function model () : string
    {
        return Product::class;
    }
}