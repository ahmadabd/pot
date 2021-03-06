<?php

use App\Http\Controllers\FertilizerController;
use App\Http\Controllers\FertilizerReportController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WateringController;
use App\Http\Controllers\WateringReportController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(static function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::delete('logout', 'logout')->name('logout');
});


Route::prefix('v1')->
    middleware(['auth:sanctum', 'getUser'])->
    group(static function() {
        Route::get('/flower/{id}', [FlowerController::class, 'getFlower'])->name('flowers.get');
        Route::get('/flower', [FlowerController::class, 'getFlowers'])->name('flowers.getAll');
        Route::post('/flower', [FlowerController::class, 'create'])->name('flowers.create');
        Route::put('/flower/{flower}', [FlowerController::class, 'update'])->name('flowers.update');
        Route::delete('/flower/{flower}', [FlowerController::class, 'delete'])->name('flowers.delete');

        Route::post('/watering/period/{flower}', [WateringController::class, 'addWateringPeriod'])->name('watering.period.add');
        Route::post('/watering/{flower}', [WateringController::class, 'wateringFlower'])->name('watering.add');
        Route::get('/watering/today', [WateringController::class, 'getUserTodoyWatering'])->name('watering.today');
        Route::get('/watering/today/all', [WateringController::class, 'getTodoyWatering'])->name('watering.today.all');

        Route::post('/fertilizer', [FertilizerController::class, 'createFertilizer'])->name('fertilizer.add');
        Route::get('/fertilizer', [FertilizerController::class, 'getFertilizers'])->name('fertilizer.getAll');
        Route::post('/fertilizer/period/{flower}', [FertilizerController::class, 'addFlowerFertilizerPeriodANDAmount'])->name('fertilizer.period.add');
        Route::post('/fertilizer/{flower}', [FertilizerController::class, 'fertilizingFlower'])->name('fertilizing.add');
        Route::get('/fertilize/today', [FertilizerController::class, 'getUserTodoyFertilizing'])->name('fertilizing.today');
        Route::get('/fertilize/today/all', [FertilizerController::class, 'getTodoyFertilizing'])->name('fertilizing.today.all');

        Route::get('/watering/report', [WateringReportController::class, 'getWateringReports'])->name('watering.reports');
        Route::get('/watering/report/{flower}', [WateringReportController::class, 'getWateringReport'])->name('watering.report');

        Route::get('/fertilizing/report', [FertilizerReportController::class, 'getFertilizingReports'])->name('fertilizing.reports');
        Route::get('/fertilizing/report/{flower}', [FertilizerReportController::class, 'getFertilizingReport'])->name('fertilizing.report');

        Route::get('/report/flower', [ReportController::class, 'getAllFlowerReports'])->name('report.flowers');
        Route::get('/report/flower/{flower}', [ReportController::class, 'getFlowerReports'])->name('report.flower');
        Route::post('/report/flower/{flower}', [ReportController::class, 'addFlowerReport'])->name('report.flower.add');
});