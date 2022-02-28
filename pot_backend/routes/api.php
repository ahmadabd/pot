<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(static function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::delete('logout', 'logout')->name('logout');
});


Route::prefix('v1')->
    middleware(['auth:sanctum', 'getUser'])->
    group(static function() {
        Route::post('/flower', [FlowerController::class, 'create'])->name('flowers.create');
});