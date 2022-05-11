<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;

class AppRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryContract::class    => UserRepository::class,
        ProductRepositoryContract::class => ProductRepository::class,

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
