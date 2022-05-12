<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => ['default.headers', 'auth:sanctum']], function ()
{
    Route::post('register', [AuthController::class, 'register'])
         ->withoutMiddleware(['auth:sanctum']);

    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);

    Route::post('logout/{options?}', [AuthController::class, 'logout'])
         ->where(['options' => 'all-devices']);

    Route::group(['prefix' => 'products'], function ()
    {
        Route::group(['prefix' => '{product_id}'], function ()
        {
            Route::get('', [ProductController::class, 'read']);
        });
    });


    Route::group(['prefix' => 'categories'], function ()
    {
        Route::get('', [CategoryController::class, 'readMany']);
    });


    Route::group(['prefix' => 'users'], function ()
    {
        Route::group(['prefix' => '{user_id}'], function ()
        {
            Route::group(['prefix' => 'carts'], function ()
            {
                Route::get('', [UserController::class, 'readManyProductCarts']);

                Route::group(['prefix' => '{product_id}'], function ()
                {
                    Route::patch('quantity', [UserController::class, 'updateProductCartQuantity']);

                    Route::post('', [UserController::class, 'storeProductCart']);
                });
            });

            Route::get('orders', [OrderController::class, 'readManyByUserId']);
        });
    });
});


