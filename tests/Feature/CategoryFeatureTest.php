<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Factories\CategoryFactory;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    public function test_should_return_a_404_when_category_does_not_exist(): void
    {
        $slug = 'non-existent-category';

        $response = $this->getJson('/categories/'.$slug);

        $response->assertStatus(404);
    }

    public function test_can_list_of_categories(): void
    {
        CategoryFactory::new()->count(13)->create();
        $response = $this->getJson('/categories');

        $response->assertStatus(200);
    }

    public function test_should_return_a_category_resource_when_category_exists(): void
    {
        $category = CategoryFactory::new()->createOne();
        $response = $this->getJson('/category/'.$category->slug);

        $response->assertStatus(200);
    }
}
