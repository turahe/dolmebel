<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ShopRepositoryInterface;
use App\Enums\OrganizationType;
use App\Events\Shop\ShopCreated;
use App\Events\Shop\ShopDeleted;
use App\Events\Shop\ShopUpdated;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Turahe\Core\Repositories\BaseRepository;

class ShopRepository extends BaseRepository implements ShopRepositoryInterface
{
    public function __construct(Shop $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws \Exception
     */
    public function createShop(array $data): Shop
    {
        $data['type'] = OrganizationType::Store;
        $data['slug'] = Str::slug($data['name']);
        try {
            $shop = $this->model->create($data);
            event(new ShopCreated($shop, Auth::user()));

            return $shop;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateShop(array $data): bool
    {
        try {
            event(new ShopUpdated($this->model));

            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteShop(): bool
    {
        try {

            return $this->model->forceDelete();

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function trashShop(): bool
    {
        try {
            event(new ShopDeleted($this->model));

            return $this->model->delete();

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getShopsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    public function getShops(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getShopsBuilder($order, $sort)->get()->except($except);
    }

    public function getIdShop(string $id): Shop
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getShopBySlug(string $slug): Shop
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getShopByCode(string $code): Shop
    {
        try {
            return $this->model->where('code', $code)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function emptyTrash(): bool
    {
        try {
            return $this->model->query()->onlyTrashed()->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function massTrash(array $ids): bool
    {
        try {
            return $this->model->query()->onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function massDestroy(array $ids): bool
    {
        try {
            return $this->model->query()->whereIn('id', $ids)->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
