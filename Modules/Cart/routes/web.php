<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->middleware('throttle:cart-mutations')->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->middleware('throttle:cart-mutations')->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->middleware('throttle:cart-mutations')->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->middleware('throttle:cart-mutations')->name('cart.clear');
});
