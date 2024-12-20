<?php

Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products');

Route::group(['middleware' => 'auth'], function () {
    Route::post('product/{id}/wishlist', [\App\Http\Controllers\ProductController::class, 'addToWishList'])->name('products.wishlist');
});
