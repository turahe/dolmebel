<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\PageRepositoryInterface;
use App\Models\Page;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Turahe\Core\Repositories\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createPage(array $data): Page
    {
        $data['type'] = 'page';
        $data['layout'] = 'page';
        $data['is_sticky'] = false;
        if (empty($data['subtitle'])) {
            $data['subtitle'] = $data['title'];
        }

        if (empty($data['description'])) {
            $data['description'] = Str::limit($data['content'], 150);
        }
        if (empty($data['language'])) {
            $data['language'] = config('app.locale');
        }

        return DB::transaction(function () use ($data) {
            $page = $this->model->create($data);
            $page->setContents($data['content']);
            if (isset($data['tags'])) {
                $page->attachTags($data['tags'], 'tag');
            }

            return $page;
        });
    }

    /**
     * Update pages
     *
     * @throws \Throwable
     */
    public function updatePage(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $page = $this->model->update(array_filter($data));

            if (isset($data['content'])) {
                $this->model->setContents($data['content']);
            }

            if (isset($data['tags'])) {
                $this->model->syncTagsWithType($data['tags'], 'tag');
            }

            return $page;
        });
    }

    /**
     * @throws Exception
     */
    public function deletePage(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function trashPage(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getPagesBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()
            ->with(['contents'])
            ->where('type', 'page')
            ->orderBy($order, $sort);

    }

    public function getPages(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getPagesBuilder()->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getPageBySlug(string $slug): Page
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function massTrashPages(array $ids): bool
    {
        try {
            return $this->model->whereIn('id', $ids)->delete();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function massRestorePages(array $ids): bool
    {
        try {
            return $this->model->onlyTrashed()->whereIn('id', $ids)->delete();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function massDestroyPages(array $ids): bool
    {
        try {
            return $this->model->whereIn('id', $ids)->forceDelete();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function emptyTrashPages(): bool
    {
        try {
            return $this->model->onlyTrashed()->forceDelete();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function onlyTrashPages(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * @throws Exception
     */
    public function restore(): bool
    {
        try {
            return $this->model->restore();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
