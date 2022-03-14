<?php

namespace App\Providers;

use App\Interfaces\FlowerRepositoryInterface;
use App\Repositories\FlowerRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlowerRepositoryInterface::class, FlowerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
