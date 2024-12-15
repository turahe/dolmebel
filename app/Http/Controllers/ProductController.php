<?php

namespace App\Http\Controllers;

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
}
