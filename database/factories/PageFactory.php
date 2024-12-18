<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph(2),
            'type' => 'page',
            'is_sticky' => $this->faker->boolean,
            'published_at' => $this->faker->dateTimeBetween('-2 months'),
            'language' => $this->faker->randomElement(['en', 'id']),
            'layout' => 'page',
        ];
    }
}
