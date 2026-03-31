<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;
use Modules\Categories\Http\Controllers\ProductController;

Route::middleware(['web'])->group(function () {
    // Public routes for browsing
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category:slug}', [CategoriesController::class, 'show'])->name('categories.show');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
});

// Admin — categories and all products
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoriesController::class)->names('categories');
    Route::resource('products', ProductController::class)->except(['show'])->names('products');
});

// Supplier — own products only (public product detail is on products.show)
Route::middleware(['auth', 'verified', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::resource('products', ProductController::class)->except(['show'])->names('products');
});
