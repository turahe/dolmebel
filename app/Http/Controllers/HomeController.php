<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Turahe\SEOTools\Contracts\Tools;

class HomeController extends Controller
{
    public function __construct(private Tools $meta) {}

    public function __invoke(Request $request)
    {
        $this->meta->setTitle('Home');
        $products = Product::with(['post', 'media', 'prices'])->take(8)->get();
        $categories = Category::whereNull('parent_id')->with(['media'])->get();

        return view('welcome', compact('products', 'categories'));

    }
}
