<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\WebAuthController;

// Authentication routes - Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->middleware('throttle:auth-login');

    Route::get('/register', [WebAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register'])->middleware('throttle:auth-register');
});

// Logout - Requires authentication
Route::post('/logout', [WebAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
