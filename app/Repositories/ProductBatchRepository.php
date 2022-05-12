<?php

namespace App\Repositories;

use App\Models\ProductBatch;
use App\Repositories\Abstracts\BaseRepository;

class ProductBatchRepository extends BaseRepository implements Contracts\ProductBatchRepositoryContract
{
    function model () : string
    {
        return ProductBatch::class;
    }
}