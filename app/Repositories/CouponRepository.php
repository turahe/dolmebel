<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CouponRepositoryInterface;
use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Post
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function update(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function delete(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getCoupons(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getCouponsBuilder($order, $sort)->get()->except($except);
    }

    public function getCouponsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    /**
     * @throws Exception
     */
    public function getCoupon(string $slug): Post
    {
        try {
            return $this->model->where('slug', $slug)->first();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
