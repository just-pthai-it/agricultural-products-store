<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\OrderServiceContract;
use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceContract::class     => AuthService::class,
        ProductServiceContract::class  => ProductService::class,
        CategoryServiceContract::class => CategoryService::class,
        UserServiceContract::class     => UserService::class,
        OrderServiceContract::class    => OrderService::class,

    ];

    /**
     * Register any application services.
     * @return void
     */
    public function register ()
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot ()
    {
        //
    }
}
