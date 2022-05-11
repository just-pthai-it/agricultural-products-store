<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\CategoryServiceContract;

class CategoryController extends Controller
{
    private CategoryServiceContract $categoryService;

    /**
     * @param CategoryServiceContract $categoryService
     */
    public function __construct (CategoryServiceContract $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function readMany (Request $request)
    {
        return $this->categoryService->readMany($request->all());
    }
}
