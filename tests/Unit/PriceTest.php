<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Price;
use App\Models\Service;
use Database\Factories\CategoryFactory;
use Database\Factories\PriceFactory;
use Database\Factories\ServiceFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tests\TestCase;

class PriceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = ServiceFactory::new()->createOne([
            'category_id' => CategoryFactory::new()->createOne()->getKey(),
        ]);
    }

    public function test_return_empty_prices_collection_when_eloquent_has_no_prices(): void
    {

        $this->assertEmpty($this->service->prices);

    }

    public function test_can_list_all_prices(): void
    {
        PriceFactory::new()->count(6)->create([
            'model_type' => $this->service->getMorphClass(),
            'model_id' => $this->service->getKey(),
        ]);

        $this->assertInstanceOf(Collection::class, Price::all());
        $this->assertCount(6, Price::all()); // +1 in the TestCase
    }

    public function test_can_delete_the_price(): void
    {
        $price = PriceFactory::new()->create([
            'model_type' => $this->service->getMorphClass(),
            'model_id' => $this->service->getKey(),
        ]);

        $deletedTrash = $price->delete();

        $this->assertTrue($deletedTrash);
        $this->assertDatabaseMissing('comments', []);
    }

    public function test_can_create_a_price(): void
    {
        $data = [

            'sale' => $this->faker->randomFloat(),
            'cogs' => $this->faker->randomDigitNotNull(),
            'currency' => 'IDR',
        ];

        $price = $this->service->setPrice($data['sale'], $data['cogs'], $data['currency']);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals($data['sale'], $price->sale);
        $this->assertEquals($data['cogs'], $price->cogs);
        $this->assertEquals($data['currency'], $price->currency);
    }

    public function test_errors_creating_the_price(): void
    {
        $this->expectException(Exception::class);

        $service = ServiceFactory::new()->createOne();
        $service->serPrice();
    }

    public function test_price_has_relation(): void
    {
        $price = PriceFactory::new()->createOne([
            'model_type' => $this->service->getMorphClass(),
            'model_id' => $this->service->getKey(),
        ]);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertInstanceOf(Service::class, $price->model);
        $this->assertInstanceOf(MorphTo::class, $price->model());
    }
}
