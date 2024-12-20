<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\BlogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Turahe\SEOTools\Contracts\Tools;

class BlogController
{
    public function __construct(
        private Tools $meta,
        private BlogRepositoryInterface $blogRepository,
    ) {}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $this->meta->setTitle('Blogs');

        $blogs = app(Pipeline::class)
            ->send($this->blogRepository->getBlogsBuilder($request->input('order', 'created_at'), $request->input('sort', 'DESC')))
            ->through([
                \App\Http\Pipelines\QueryFilters\Search::class,
            ])
            ->thenReturn()
            ->paginate($request->input('limit', 12));

        return view('blogs.index', compact('blogs'));

    }

    public function show(string $slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $blog = $this->blogRepository->getBlog($slug);

        return view('blogs.show', compact('blog'));
    }
}
