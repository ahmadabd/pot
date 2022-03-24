<?php

namespace App\Providers;

use App\Repositories\Flower\FlowerRepositoryInterface;
use App\Repositories\Flower\FlowerRepository;
use App\Repositories\Watering\WateringRepository;
use App\Repositories\Watering\WateringRepositoryInterface;
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
        $this->app->bind(WateringRepositoryInterface::class, WateringRepository::class);
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
