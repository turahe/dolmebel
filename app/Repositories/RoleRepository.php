<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getRole($id): Role
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getPermissions($roleId): void
    {
        // TODO: Implement getPermissions() method.
    }

    /**
     * @throws Exception
     */
    public function getRoleByName($name): Role
    {
        try {
            return $this->model->where('name', $name)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function getRoleBySlug($slug): Role
    {
        try {
            return $this->model->where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function createRole(array $attributes): Role
    {
        try {
            return $this->model->create($attributes);
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateRole(array $attributes): bool
    {
        try {
            return $this->model->update(array_filter($attributes));
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteRole(): bool
    {
        try {
            return $this->model->delete();
        } catch (
            ModelNotFoundException $exception
        ) {
            throw new Exception($exception->getMessage());
        }
    }
}
