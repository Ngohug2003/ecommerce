<?php
// routes/web.php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Public routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/profile', [AuthController::class, 'show'])->name('profile.show');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Admin routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
});
