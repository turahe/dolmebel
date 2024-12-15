<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Events\User\PasswordUpdated;
use App\Events\User\ProfileUpdated;
use App\Models\User;
use App\Notifications\Users\ProfileUpdatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Turahe\Core\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;

    }

    /**
     * @throws \Exception
     */
    public function createUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        if (array_key_exists('phone', $data)) {
            $data['phone'] = parse_phone($data['phone'], $data['country']);
        }
        try {
            $user = $this->model->create($data);
            if ($user instanceof MustVerifyEmail) {
                event(new Registered($user));
            }

            return $user;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateUser(array $data): bool
    {
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        try {
            event(new ProfileUpdated($this->model));

            return $this->model->update($data);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteUser(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Get all users collection
     */
    public function getUsers(string $order = 'created_at', string $sort = 'desc', array $except = []): Collection
    {
        return $this->getUsersBuilder($order, $sort)->get()->except($except);
    }

    /**
     * @throws \Exception
     */
    public function getUsername(string $username): User
    {
        try {
            return $this->model->where('username', $username)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getEmail(string $email): User
    {
        try {
            return $this->model->where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getPhone(string $phone): User
    {
        try {
            return $this->model->where('phone', $phone)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function getId(string $id): User
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updatePassword(string $password): bool
    {
        try {
            event(new PasswordUpdated($this->model));

            return $this->model->update([
                'password' => bcrypt($password),
            ]);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function updateEmail(string $email): bool
    {
        try {
            Notification::send($this->model, new ProfileUpdatedNotification('email'));

            return $this->model->update([
                'email' => $email,
            ]);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function updateUsername(string $username): bool
    {
        try {
            Notification::send($this->model, new ProfileUpdatedNotification('username'));

            return $this->model->update([
                'username' => $username,
            ]);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function updatePhone(string $phone): bool
    {
        try {
            Notification::send($this->model, new ProfileUpdatedNotification('phone'));

            return $this->model->update([
                'phone' => $phone,
            ]);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function trash(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function restore(): bool
    {
        try {
            return $this->model->restore();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function massDestroy(array $ids): bool
    {
        try {
            return (bool) $this->model->whereIn('id', $ids)->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function emptyTrash(): bool
    {
        try {
            return (bool) $this->model->onlyTrashed()->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getUsersBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()
            ->with(['roles', 'media'])
            ->orderBy($order, $sort);
    }
}
