<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\CartAble;
use App\Events\Cart\CartDecreaseQuantityEvent;
use App\Events\Cart\CartEmptyEvent;
use App\Events\Cart\CartIncreaseQuantityEvent;
use App\Events\Cart\CartRemoveItemEvent;
use App\Events\Cart\CartStoreItemEvent;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use Turahe\Ledger\Models\Invoice;

class Cart extends Invoice
{
    /**
     * Calculate price by quantity of items.
     */
    public function calculatedPriceByQuantity(): int
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += (int) $item->quantity * (int) $item->itemable->getPrice();
        }

        return $totalPrice;
    }

    /**
     * Store multiple items in cart.
     */
    public function storeItems(array $items): static
    {
        foreach ($items as $item) {
            $this->storeItem($item);
        }

        return $this;
    }

    /**
     * Store cart item in cart.
     */
    public function storeItem(Model|array $item): static
    {
        if (is_array($item)) {
            $item['itemable_id'] = $item['itemable']->getKey();
            $item['itemable_type'] = get_class($item['itemable']);
            $item['quantity'] = (int) $item['quantity'];

            if ($item['itemable'] instanceof Cartable) {
                $this->items()->create($item);
            } else {
                throw new RuntimeException('The item must be an instance of Cartable');
            }
        } else {
            $this->items()->create([
                'itemable_id' => $item->getKey(),
                'itemable_type' => get_class($item),
                'itemable_quantity' => 1,
            ]);
        }

        // Dispatch Event
        CartStoreItemEvent::dispatch();

        return $this;
    }

    /**
     * Remove a single item from the cart
     */
    public function removeItem(Model $item): static
    {
        $itemToDelete = $this->items()->find($item->getKey());

        if ($itemToDelete) {
            $itemToDelete->delete();
        }

        // Dispatch Event
        CartRemoveItemEvent::dispatch();

        return $this;
    }

    /**
     * Remove every item from the cart
     */
    public function emptyCart(): static
    {
        $this->items()->delete();

        // Dispatch Event
        CartEmptyEvent::dispatch();

        return $this;
    }

    /**
     * Increase the quantity of the item.
     */
    public function increaseQuantity(Model $item, int $quantity = 1): static
    {
        $item = $this->items()->firstWhere('itemable_id', $item->getKey());
        if (! $item) {
            throw new RuntimeException('The item not found');
        }

        $item->increment('quantity', $quantity);

        // Dispatch Event
        CartIncreaseQuantityEvent::dispatch($item);

        return $this;
    }

    /**
     * Decrease the quantity of the item.
     */
    public function decreaseQuantity(Model $item, int $quantity = 1): static
    {
        $item = $this->items()->find($item->getKey());
        if (! $item) {
            throw new RuntimeException('The item not found');
        }

        $item->decrement('quantity', $quantity);

        // Dispatch Event
        CartDecreaseQuantityEvent::dispatch($item);

        return $this;
    }
}
