<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface FaqRepositoryInterface extends BaseRepositoryInterface
{
    public function createFaq(array $data): Faq;

    public function updateFaq(array $data): bool;

    public function deleteFaq(): bool;

    public function getFaqs(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getFaqsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function getIdFaq(string $id): Faq;
}
