<?php

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AuthServiceContract;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceContract::class => AuthService::class,

    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
