<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;
use Turahe\Ledger\Models\Voucher;

interface RefundRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllRefunds(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getAllRefundsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder;

    public function createRefund(array $data): Refund;

    public function updateRefund(array $data): bool;

    /**
     * @return mixed
     */
    public function open(): Collection;

    /**
     * @return mixed
     */
    public function statusOf($status): Collection;

    /**
     * @return mixed
     */
    public function approve(): bool;

    /**
     * @return mixed
     */
    public function decline(): bool;

    public function getIdRefund(string $id): Refund;

    /**
     * @return mixed
     */
    public function findOrder(string $voucher): Voucher;
}
