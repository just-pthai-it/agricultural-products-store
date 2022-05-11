<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Contracts\CategoryRepositoryContract;

class AppRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryContract::class     => UserRepository::class,
        ProductRepositoryContract::class  => ProductRepository::class,
        CategoryRepositoryContract::class => CategoryRepository::class,
        OrderRepositoryContract::class    => OrderRepository::class,

    ];

    /**
     * Register services.
     * @return void
     */
    public function register ()
    {
        //
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot ()
    {
        //
    }
}
