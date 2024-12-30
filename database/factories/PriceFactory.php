<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomNumber(3, true);

        return [
            'currency' => 'IDR',
            'cogs' => ($price + mt_rand(100, 1000)) * 1000,
            'sale' => $price * 1000,
        ];
    }
}
