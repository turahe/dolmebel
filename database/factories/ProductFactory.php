<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {

        return [
            'qrcode' => $this->faker->uuid(),
            'barcode' => $this->faker->uuid(),
            'post_id' => PostFactory::new()->create(['type' => 'product'])->getKey(),

        ];
    }
}
