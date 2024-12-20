<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ShopRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ShopController
{
    public function __construct(private ShopRepositoryInterface $shopRepository) {}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $shops = app(Pipeline::class)
            ->send($this->shopRepository->getShopsBuilder($request->input('order', 'created_at'), $request->input('sort', 'DESC')))
            ->through([
                \App\Http\Pipelines\QueryFilters\Search::class,
            ])
            ->thenReturn()
            ->paginate($request->input('limit', 12));

        return view('shops.index', ['shops' => $shops]);
    }

    /**
     * Get Detail shops
     */
    public function show(string $slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $shop = $this->shopRepository->getShopBySlug($slug);

        return view('shops.show', ['shop' => $shop]);
    }
}
