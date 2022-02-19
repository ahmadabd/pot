<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Services\TokenManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\ServiceProvider;

class TokenManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserController::class, static fn() => new UserController(
            $this->app->make(TokenManager::class),
            $this->app->make(Authenticatable::class)
        ));
    }
}
