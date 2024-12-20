<?php

Route::get('catalog', [\App\Http\Controllers\ProductController::class, 'catalog'])->name('catalog');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::get('blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs');
Route::get('blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::get('shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('shop/{slug}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');

Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('category/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

Route::get('contact-us', function () {
    return view('contact_us');
});
