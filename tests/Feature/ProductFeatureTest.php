<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Database\Factories\SupplierFactory;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    protected $brand;

    protected $product;

    protected $supplier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->brand = BrandFactory::new()->create();
        $this->category = CategoryFactory::new()->create();
        $this->supplier = SupplierFactory::new()->create();
    }

    public function test_should_return_a_404_when_product_does_not_exist(): void
    {
        $slug = 'non-existent-product';

        $response = $this->getJson('/product/'.$slug);

        $response->assertStatus(404);
    }

    public function test_can_list_of_products(): void
    {
        ProductFactory::new()->count(13)->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);
        $response = $this->get('/catalog');

        $response->assertStatus(200);
    }

    public function test_should_return_a_product_resource_when_product_exists(): void
    {
        $product = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);
        $response = $this->get('/product/'.$product->slug);

        $response->assertStatus(200)
            ->assertSee("$product->name")
            ->assertSee("$product->slug");
    }
}
