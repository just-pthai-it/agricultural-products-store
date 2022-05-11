<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Abstracts\BaseRepository;

class CategoryRepository extends BaseRepository implements Contracts\CategoryRepositoryContract
{
    function model () : string
    {
        return Category::class;
    }
}