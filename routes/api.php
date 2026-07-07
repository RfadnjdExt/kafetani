<?php

use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\FarmerController as AdminFarmerController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\Kasir\OrderController as KasirOrderController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

// Semua route di file ini otomatis masuk grup middleware 'api' (stateless,
// tanpa sesi/CSRF — lihat bootstrap/app.php) dan otomatis dapat prefix
// '/api'. File ini khusus dipakai aplikasi Android (native), bukan web.
//
// Auth pakai token kustom (bukan Sanctum, lihat AppServiceProvider +
// config/auth.php guard 'api') — dikirim via header:
//   Authorization: Bearer <token>

// ─── Auth ───────────────────────────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login',    [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me',      [AuthController::class, 'me'])->name('api.me');
});

// ─── Katalog publik (tanpa login) ──────────────────────────────────────────
Route::get('/menu',               [CatalogController::class, 'menu'])->name('api.menu');
Route::get('/marketplace',        [CatalogController::class, 'marketplace'])->name('api.marketplace');
Route::get('/categories',         [CatalogController::class, 'categories'])->name('api.categories');
Route::get('/farmers',            [CatalogController::class, 'farmers'])->name('api.farmers');
Route::get('/products/{product}', [CatalogController::class, 'product'])->name('api.products.show');

// ─── Pesanan pelanggan (perlu login) ───────────────────────────────────────
Route::middleware('auth:api')->group(function () {
    Route::post('/orders',        [OrderController::class, 'store'])->name('api.orders.store');
    Route::get('/orders',         [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('api.orders.show');
});

// ─── Admin (role admin saja) ────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->name('api.admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/products',            [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products',           [AdminProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/farmers',            [AdminFarmerController::class, 'index'])->name('farmers.index');
    Route::post('/farmers',           [AdminFarmerController::class, 'store'])->name('farmers.store');
    Route::post('/farmers/{farmer}',  [AdminFarmerController::class, 'update'])->name('farmers.update');
    Route::delete('/farmers/{farmer}', [AdminFarmerController::class, 'destroy'])->name('farmers.destroy');

    Route::get('/orders',                 [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// ─── Kasir (role admin & kasir) ─────────────────────────────────────────────
Route::prefix('kasir')->middleware(['auth:api', 'role:admin,kasir'])->name('api.kasir.')->group(function () {
    Route::get('/products', [KasirOrderController::class, 'products'])->name('products');
    Route::post('/orders',  [KasirOrderController::class, 'store'])->name('orders.store');
});
