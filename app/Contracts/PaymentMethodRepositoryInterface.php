<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\PaymentMethod;
use Illuminate\Support\Collection;
use Turahe\Core\Contracts\BaseRepositoryInterface;

interface PaymentMethodRepositoryInterface extends BaseRepositoryInterface
{
    public function createPaymentMethod(array $data): PaymentMethod;

    public function updatePaymentMethod(array $data): bool;

    public function deletePaymentMethod(): bool;

    public function getPaymentMethods(string $order = 'created_at', string $sort = 'desc', $except = []): Collection;

    public function getIdPaymentMethod(string $id): PaymentMethod;

    public function getCodePaymentMethod(string $code): PaymentMethod;
}
