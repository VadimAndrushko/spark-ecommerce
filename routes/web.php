<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', [ProductController::class, 'index'])->name('home');

// Products
Route::get('/catalog', [ProductController::class, 'catalog'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginShow'])->name('login.show');
    Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'registerShow'])->name('register.show');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Cart & Shopping (protected)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Reviews
    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile & Account
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses.index');
    Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
});
