<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Services\Token\TokenManager;
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
        $this->app->bind(UserController::class, static fn($app) => new UserController(
            $app->make(TokenManager::class),
            $app->make(Authenticatable::class)
        ));
    }
}
