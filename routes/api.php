<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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
    Route::post('register', [AuthController::class, 'register'])->withoutMiddleware(['auth:sanctum']);

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
});


