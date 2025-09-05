<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Tailstore Routes
Route::get('/', function () {
    return Inertia::render('Tailstore/Home');
})->name('home');

Route::get('/shop', function () {
    return Inertia::render('Tailstore/Products/Catalog');
})->name('products.catalog');

Route::get('/cart', function () {
    return Inertia::render('Tailstore/Cart');
})->name('cart');

Route::get('/checkout', function () {
    return Inertia::render('Tailstore/Checkout');
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
