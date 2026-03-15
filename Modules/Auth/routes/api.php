<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('user.register');
        Route::post('login', 'login')->name('user.login');
        Route::post('logout', 'logout')->name('user.logout')
            ->middleware('auth:sanctum');
    })->middleware('throttle:api');
});
