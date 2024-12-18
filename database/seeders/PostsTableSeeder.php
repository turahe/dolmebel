<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Blog;
use Database\Factories\BlogFactory;
use Database\Factories\PageFactory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogFactory::new()->count(100)->create()->each(function (Blog $post): void {
            $post->setContents(fake()->text);
            $comment = $post->addComment(fake()->sentence);
            $comment->addComment(fake()->sentence);
            $post->attachTags([fake()->word, fake()->word], $post->type);
        });

        PageFactory::new()->count(100)->create(['type' => 'faq', 'layout' => 'faq']);
        PageFactory::new()->count(13)->create(['type' => 'page', 'layout' => 'page']);
    }
}
