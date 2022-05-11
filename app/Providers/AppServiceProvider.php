<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\ProductServiceContract;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceContract::class    => AuthService::class,
        ProductServiceContract::class => ProductService::class,

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
