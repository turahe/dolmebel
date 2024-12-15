<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

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
            'type' => 'blog',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_sticky' => $this->faker->boolean,
            'language' => $this->faker->randomElement(['en', 'id']),
            'layout' => 'blog',
        ];
    }
}
