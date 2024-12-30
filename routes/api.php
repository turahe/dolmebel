<?php

use Illuminate\Support\Facades\Route;

Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('product/{id}/comments', [\App\Http\Controllers\ProductController::class, 'comments'])->name('product.comments');
Route::get('media/{id}', \App\Http\Controllers\MediaController::class)->name('media');
Route::group(['middleware' => 'auth'], function () {
    Route::post('product/wishlist', [\App\Http\Controllers\ProductController::class, 'addToWishList'])->name('products.wishlist');
    Route::post('product/cart', [\App\Http\Controllers\ProductController::class, 'addCart'])->name('products.cart');
});
