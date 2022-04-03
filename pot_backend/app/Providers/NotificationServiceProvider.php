<?php

namespace App\Providers;

use App\Console\Commands\FertilizingToday;
use App\Console\Commands\WateringToday;
use App\Services\Notification\Notify;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
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
        $this->app->bind(WateringToday::class, static fn($app) => new WateringToday(
            $app->make(Notify::class),
        ));

        $this->app->bind(FertilizingToday::class, static fn($app) => new FertilizingToday(
            $app->make(Notify::class),
        ));
    }
}
