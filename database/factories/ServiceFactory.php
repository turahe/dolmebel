<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->randomNumber(5, true),
            'post_id' => PostFactory::new()->create(['type' => 'service'])->getKey(),
            'category_id' => CategoryFactory::new()->create()->getKey(),
        ];
    }
}
