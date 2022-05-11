<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryService implements Contracts\CategoryServiceContract
{
    private CategoryRepositoryContract $categoryRepository;

    /**
     * @param CategoryRepositoryContract $categoryRepository
     */
    public function __construct (CategoryRepositoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function readMany (array $inputs) : AnonymousResourceCollection
    {
        $categories = $this->categoryRepository->find(['*'], [], [], [], [['filter', $inputs]]);
        return CategoryResource::collection($categories);
    }
}