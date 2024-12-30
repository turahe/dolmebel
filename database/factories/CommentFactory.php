<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Turahe\Comment\Enums\CommentType;
use Turahe\Comment\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Turahe\Comment\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'type' => CommentType::COMMENT,
            'published_at' => now(),
        ];
    }
}
