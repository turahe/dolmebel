<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    protected $model = Slide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph(2),
            'type' => 'slide',
            'is_sticky' => $this->faker->boolean,
            'language' => $this->faker->randomElement(['en', 'id']),
            'layout' => 'slide',
        ];
    }
}
