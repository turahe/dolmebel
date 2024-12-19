<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Manufacture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacture>
 */
class ManufactureFactory extends Factory
{
    protected $model = Manufacture::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
