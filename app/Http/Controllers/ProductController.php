<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Category;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function catalog()
    {
        $categories = Category::whereNull('parent_id')->get();

        return Inertia::render('Tailstore/Products/Catalog', [
            'categories' => $categories,
        ]);
    }

    public function detail(string $slug)
    {
        $product = app(ProductRepositoryInterface::class)->getProductBySlug($slug);

        // Sample related products - replace with actual related products logic
        $relatedProducts = [];

        return Inertia::render('Product/Detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
