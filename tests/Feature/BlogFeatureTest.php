<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Factories\BlogFactory;
use Tests\TestCase;

class BlogFeatureTest extends TestCase
{
    public function test_should_return_a_404_when_blog_does_not_exist(): void
    {
        $slug = 'non-existent-blog';

        $response = $this->get('/blog/'.$slug);

        $response->assertStatus(404);
    }

    public function test_can_list_of_blogs(): void
    {
        BlogFactory::new()->count(13)->create();
        $response = $this->getJson('/blogs');

        $response->assertStatus(200);
    }

    public function test_should_return_a_blog_resource_when_blog_exists(): void
    {
        $blog = BlogFactory::new()->create();
        $response = $this->get('/blog/'.$blog->slug);

        $response->assertStatus(200);

    }
}
