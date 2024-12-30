<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Turahe\SEOTools\Contracts\Tools;

class ProductController extends Controller
{
    public function __construct(private Tools $meta) {}

    public function index(Request $request)
    {
        $products = app(Pipeline::class)
            ->send(Product::query()->with(['media', 'post', 'prices']))
            ->through([
                \App\Http\Pipelines\QueryFilters\Search::class,
                \App\Http\Pipelines\QueryFilters\ParentId::class,
                \App\Http\Pipelines\QueryFilters\CategoryId::class,
                \App\Http\Pipelines\QueryFilters\BrandId::class,
            ])
            ->thenReturn()
            ->paginate($request->input('limit', 12));

        return ProductResource::collection($products);
    }

    public function catalog()
    {
        return view('products.catalog');

    }

    public function show(string $slug)
    {
        $product = app(ProductRepositoryInterface::class)->getProductBySlug($slug);

        $this->meta->setTitle($product->name);
        $this->meta->setDescription($product->description);
        $this->meta->addImages($product->image);

        return view('products.detail', compact('product'));
    }

    public function comments(string $id)
    {
        $product = app(ProductRepositoryInterface::class)->getProduct($id);
        $comments = app(Pipeline::class)
            ->send($product->comments()->with(['author.media']))
            ->through([
                \App\Http\Pipelines\QueryFilters\Search::class,
                \App\Http\Pipelines\QueryFilters\ParentId::class,
            ])
            ->thenReturn()
            ->paginate(10);

        return CommentResource::collection($comments);

    }

    public function wishlist(string $id)
    {
        $product = app(ProductRepositoryInterface::class)->getProduct($id);
        $productRepo = new ProductRepository($product);
        $productRepo->addToWishlist();

        return response()->json(['data' => 'Product was successfully added to wishlist.']);
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        return response()->json($request->all());

    }
}
