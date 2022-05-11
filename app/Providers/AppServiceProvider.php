<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceContract::class     => AuthService::class,
        ProductServiceContract::class  => ProductService::class,
        CategoryServiceContract::class => CategoryService::class,

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
