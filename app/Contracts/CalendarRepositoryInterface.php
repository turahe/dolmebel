<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Calendar;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface CalendarRepositoryInterface extends BaseRepositoryInterface
{
    public function getCalendars(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getCalendar(string $id): Calendar;

    public function createCalendar(array $attributes): Calendar;

    public function updateCalendar(array $attributes): bool;

    public function deleteCalendar(): bool;

    public function trashCalendar(): bool;
}
