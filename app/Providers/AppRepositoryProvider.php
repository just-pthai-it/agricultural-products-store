<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryContract;

class AppRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryContract::class => UserRepository::class,
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
