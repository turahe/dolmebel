<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function createUser(array $data): User;

    public function updateUser(array $data): bool;

    public function deleteUser(): bool;

    public function getUsers(string $order = 'created_at', string $sort = 'desc', array $except = []): Collection;

    public function getUsersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getUsername(string $username): User;

    public function getEmail(string $email): User;

    public function getPhone(string $phone): User;

    public function getId(string $id): User;

    public function updatePassword(string $password): bool;

    public function updateEmail(string $email): bool;

    public function updateUsername(string $username): bool;

    public function updatePhone(string $phone): bool;

    public function restore(): bool;

    public function massDestroy(array $ids): bool;

    public function emptyTrash(): bool;
}
