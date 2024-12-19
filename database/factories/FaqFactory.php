<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph(2),
            'type' => 'faq',
            'is_sticky' => $this->faker->boolean,
            'published_at' => $this->faker->dateTimeBetween('-2 months'),
            'language' => $this->faker->randomElement(['en', 'id']),
            'layout' => 'faq',
        ];
    }
}
