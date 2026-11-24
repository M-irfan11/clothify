<?php

use App\Http\Controllers\BomItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryStockController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\StockMovementController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('product_variants', ProductVariantsController::class);
    Route::resource('bom_items', BomItemController::class);

    // Route::resource('inventory_stocks', InventoryStockController::class);

    Route::resource('inventory_stocks', InventoryStockController::class)
    ->parameters(['inventory_stocks' => 'inventoryStock'])
    ->names('inventory_stocks');


    Route::resource('stock_movements', StockMovementController::class);
    Route::resource('purchase_orders', PurchaseOrderController::class);
    Route::resource('purchase_order_items', PurchaseOrderItemController::class);
    Route::resource('production-orders', ProductionOrderController::class);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
