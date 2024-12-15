<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CalendarRepositoryInterface;
use App\Models\Calendar;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class CalendarRepository extends BaseRepository implements CalendarRepositoryInterface
{
    public function __construct(Calendar $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getCalendars(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws Exception
     */
    public function getCalendar(string $id): Calendar
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function createCalendar(array $attributes): Calendar
    {
        try {
            return $this->model->create($attributes);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateCalendar(array $attributes): bool
    {
        try {
            return $this->model->update($attributes);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteCalendar(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function trashCalendar(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
