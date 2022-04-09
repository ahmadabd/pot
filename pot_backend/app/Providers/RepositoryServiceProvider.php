<?php

namespace App\Providers;

use App\Repositories\Fertilize\FertilizeRepository;
use App\Repositories\Fertilize\FertilizeRepositoryInterface;
use App\Repositories\FertilizingReport\FertilizingReportRepository;
use App\Repositories\FertilizingReport\FertilizingReportRepositoryInterface;
use App\Repositories\Flower\FlowerRepositoryInterface;
use App\Repositories\Flower\FlowerRepository;
use App\Repositories\Report\ReportRepository;
use App\Repositories\Report\ReportRepositoryInterface;
use App\Repositories\Watering\WateringRepository;
use App\Repositories\Watering\WateringRepositoryInterface;
use App\Repositories\WateringReport\WateringReportRepositoryInterface;
use App\Repositories\WateringReport\WateringReportRepository;
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
        $this->app->bind(FertilizeRepositoryInterface::class, FertilizeRepository::class);
        $this->app->bind(WateringReportRepositoryInterface::class, WateringReportRepository::class);
        $this->app->bind(FertilizingReportRepositoryInterface::class, FertilizingReportRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
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
