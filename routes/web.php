<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Kategori Management
    Route::get('/kategoris', [AdminController::class, 'kategoris'])->name('kategoris');
    Route::get('/kategoris/create', [AdminController::class, 'createKategori'])->name('kategoris.create');
    Route::post('/kategoris', [AdminController::class, 'storeKategori'])->name('kategoris.store');
    Route::get('/kategoris/{kategori}/edit', [AdminController::class, 'editKategori'])->name('kategoris.edit');
    Route::put('/kategoris/{kategori}', [AdminController::class, 'updateKategori'])->name('kategoris.update');
    Route::delete('/kategoris/{kategori}', [AdminController::class, 'destroyKategori'])->name('kategoris.destroy');
    
    // Buku Management
    Route::get('/bukus', [AdminController::class, 'bukus'])->name('bukus');
    Route::get('/bukus/create', [AdminController::class, 'createBuku'])->name('bukus.create');
    Route::post('/bukus', [AdminController::class, 'storeBuku'])->name('bukus.store');
    Route::get('/bukus/{buku}/edit', [AdminController::class, 'editBuku'])->name('bukus.edit');
    Route::put('/bukus/{buku}', [AdminController::class, 'updateBuku'])->name('bukus.update');
    Route::delete('/bukus/{buku}', [AdminController::class, 'destroyBuku'])->name('bukus.destroy');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    
    // Pesanan Management
    Route::get('/pesanans', [AdminController::class, 'pesanans'])->name('pesanans');
    Route::put('/pesanans/{pesanan}/status', [AdminController::class, 'updateStatusPesanan'])->name('pesanans.update-status');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/about', [UserController::class, 'aboutUs'])->name('about');
    Route::get('/contact', [UserController::class, 'contact'])->name('contact');
    Route::get('/search', [UserController::class, 'search'])->name('search');
    
    // Cart Management
    Route::post('/cart/add/{buku}', [UserController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::put('/cart/{keranjang}', [UserController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{keranjang}', [UserController::class, 'removeFromCart'])->name('cart.remove');
    
    // Checkout
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [UserController::class, 'processCheckout'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
});