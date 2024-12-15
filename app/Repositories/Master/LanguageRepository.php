<?php

declare(strict_types=1);

namespace App\Repositories\Master;

use App\Contracts\Master\LanguageRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Master\Models\Language;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function createLanguage(array $data): Language
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
    public function updateLanguage(array $data): bool
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
    public function deleteLanguage(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getLanguages(): Collection
    {
        return $this->model->all();
    }

    /**
     * @throws Exception
     */
    public function getLanguageCode(string $code): Language
    {
        try {
            return $this->model->where('code', $code)->first();
        } catch (ModelNotFoundException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function trash(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
