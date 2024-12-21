<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Turahe\Core\Contracts\TaxonomyRepositoryInterface;
use Turahe\SEOTools\Contracts\Tools;

class CategoryController
{
    public function __construct(
        private Tools $meta,
        private TaxonomyRepositoryInterface $categoryRepository
    ) {}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $this->meta->setTitle('Categories');

        $relation = $request->get('relation', 'products');

        $categories = app(Pipeline::class)
            ->send(Category::query()->with(explode(',', 'media,'.$relation))->whereHas($relation))
            ->through([
                \App\Http\Pipelines\QueryFilters\Search::class,
                \App\Http\Pipelines\QueryFilters\ParentId::class,
            ])
            ->thenReturn()
            ->get();

        if ($request->expectsJson()) {
            return CategoryResource::collection($categories);
        }

        return view('category.index', compact('categories'));

    }

    public function show(string $slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $category = $this->categoryRepository->getTaxonomyBySlug($slug);

        $this->meta->setTitle($category->name);
        $this->meta->setDescription($category->description);

        return view('category.show', compact('category'));
    }
}
