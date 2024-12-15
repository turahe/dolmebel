<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Role;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRoles(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getRole(string $id): Role;

    public function getPermissions(string $roleId);

    public function getRoleByName(string $name): Role;

    public function getRoleBySlug(string $slug): Role;

    public function createRole(array $attributes): Role;

    public function updateRole(array $attributes): bool;

    public function deleteRole(): bool;
}
