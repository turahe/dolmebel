<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\FaqRepositoryInterface;
use App\Models\Faq;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;

class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    public function __construct(Faq $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createFaq(array $data): Faq
    {
        try {
            return $this->model->create($this->formatInput($data));
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function updateFaq(array $data): bool
    {
        try {
            return $this->model->update($this->formatInput($data));
        } catch (QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function deleteFaq(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function trashFaq(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getFaqs(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->getFaqsBuilder($order, $sort)->get()->except($except);
    }

    public function getFaqsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    /**
     * @throws Exception
     */
    public function getIdFaq(string $id): Faq
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function formatInput(array $data): array
    {
        $data['title'] = $data['question'];
        $data['description'] = $data['answer'];
        $data['type'] = 'faq';
        $data['layout'] = 'faq';
        if (empty($data['language'])) {
            $data['language'] = config('app.locale');
        }

        return array_filter($data);
    }
}
