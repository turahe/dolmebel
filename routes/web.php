<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('catalog', [\App\Http\Controllers\ProductController::class, 'catalog'])->name('catalog');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'detail'])->name('product.detail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
