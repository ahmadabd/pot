<?php

use App\Http\Controllers\FertilizerController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WateringController;
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

        Route::post('watering/period/{flower}', [WateringController::class, 'addWateringPeriod'])->name('watering.period.add');
        Route::post('watering/{flower}', [WateringController::class, 'wateringFlower'])->name('watering.add');

        Route::post('fertilize', [FertilizerController::class, 'createFertilizer'])->name('fertilizer.add');
        Route::post('fertilize/period/{flower}', [FertilizerController::class, 'addFlowerFertilizerPeriodANDAmount'])->name('fertilizer.period.add');
        Route::post('fertilize/{flower}', [FertilizerController::class, 'fertilizingFlower'])->name('fertilizing.add');
});