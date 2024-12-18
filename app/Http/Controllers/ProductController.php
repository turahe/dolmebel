<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Category;

class ProductController extends Controller
{
    public function catalog()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('products.catalog', [
            'categories' => $categories,
        ]);

    }

    public function detail(string $slug)
    {
        $product = app(ProductRepositoryInterface::class)->getProductBySlug($slug);

        return view('product.detail', compact('product'));
    }
}
