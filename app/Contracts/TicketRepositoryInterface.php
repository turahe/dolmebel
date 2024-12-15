<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Pipeline;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface TicketRepositoryInterface extends BaseRepositoryInterface
{
    public function createTicket(array $data): Ticket;

    public function updateTicket(array $data): bool;

    public function deleteTicket(): bool;

    public function getTickets(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getTicketsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getIdTicket(string $id): Ticket;

    public function assignTicket(array $data): bool;

    public function storeReplyTicket(string $id, string $message, Pipeline|string|null $status = 'ON_PROGRESS'): Ticket;
}
