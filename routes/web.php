<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Tailstore Routes
Route::get('/', function () {
    return view('tailstore.home');
})->name('home');

Route::get('/shop', function () {
    return view('tailstore.products.catalog');
})->name('products.catalog');

Route::get('/cart', function () {
    return view('tailstore.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('tailstore.checkout');
})->name('checkout');

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('catalog', [\App\Http\Controllers\ProductController::class, 'catalog'])->name('catalog');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'detail'])->name('product.detail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
