<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home')->middleware('auth');

// শুধু Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Admin এবং Editor
Route::middleware(['auth', 'role:admin|editor'])->group(function () {
    Route::resource('warehouses', WarehouseController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('suppliers', SupplierController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('product_variants', ProductVariantsController::class);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
