<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\ProductServiceContract;

class ProductController extends Controller
{
    private ProductServiceContract $productService;

    /**
     * @param ProductServiceContract $productService
     */
    public function __construct (ProductServiceContract $productService)
    {
        $this->productService = $productService;
    }

    public function read (Request $request, string $productId)
    {
        return $this->productService->read($productId, $request->all());
    }

    public function readMany (Request $request)
    {
        return $this->productService->readMany($request->all());
    }

    public function readManyByCategoryId (Request $request, string $categoryId)
    {
        return $this->productService->readManyByCategoryId($categoryId, $request->all());
    }
}
