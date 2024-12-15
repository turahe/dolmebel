<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TicketRepositoryInterface;
use App\Events\Ticket\TicketReply;
use App\Events\Ticket\TicketUpdated;
use App\Models\Pipeline;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use League\CommonMark\Exception\CommonMarkException;
use Turahe\Core\Repositories\BaseRepository;

class TicketRepository extends BaseRepository implements TicketRepositoryInterface
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws \Exception
     */
    public function createTicket(array $data): Ticket
    {
        try {
            $ticket = $this->model->create($data);
            $ticket->setContents($data['message']);
            $ticket->addPipeline($data['status']);

            return $ticket;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function updateTicket(array $data): bool
    {
        try {
            event(new TicketUpdated($this->model));
            $this->model->addPipeline($data['status']);

            return $this->model->update($data);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteTicket(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getTicketsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    public function getTickets(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getTicketsBuilder($order, $sort)->get()->except($except);
    }

    /**
     * @throws \Exception
     */
    public function getIdTicket(string $id): Ticket
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function reopen(): bool
    {
        try {
            $open = $this->model->detachPipeline();
            $this->model->addPipeline('NEW');

            return $open;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    public function assignTicket(array $data): bool
    {
        try {
            return $this->model->update($data);

        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws CommonMarkException|\Exception
     */
    public function storeReplyTicket(string $id, string $message, Pipeline|string|null $status = 'IN_PROGRESS'): Ticket
    {
        try {
            $ticket = $this->getIdTicket($id);
            $ticket->setContents($message);
            $ticket->addPipeline($status);
            event(new TicketReply($ticket));

            return $ticket;
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
