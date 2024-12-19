<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Manufacture;
use App\Models\Product;
use App\Repositories\ManufactureRepository;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ManufactureFactory;
use Database\Factories\ProductFactory;
use Database\Factories\SupplierFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class ManufactureTest extends TestCase
{
    public function test_can_list_all_manufactures(): void
    {
        ManufactureFactory::new()->count(6)->create();

        $manufactureRepo = new ManufactureRepository(new Manufacture);
        $manufactures = $manufactureRepo->getManufactures();

        $this->assertInstanceOf(Collection::class, $manufactures);
        $this->assertCount(6, $manufactures->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_manufacture(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $manufactureRepo = new ManufactureRepository(new Manufacture);
        $manufactureRepo->getManufacture('not-a-manufacture');

    }

    public function test_can_force_delete_the_manufacture(): void
    {
        $manufactureFactory = ManufactureFactory::new()->create();

        $manufactureRepo = new ManufactureRepository($manufactureFactory);
        $deleted = $manufactureRepo->deleteManufacture();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('manufactures', []);
    }

    public function test_can_delete_the_manufacture(): void
    {
        $manufactureFactory = ManufactureFactory::new()->create();

        $manufactureRepo = new ManufactureRepository($manufactureFactory);
        $deletedTrash = $manufactureRepo->trashManufacture();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('manufactures', ['id' => $manufactureFactory->getKey()]);
    }

    public function test_can_restore_after_delete_the_manufacture(): void
    {
        $manufactureFactory = ManufactureFactory::new()->create();

        $manufactureRepo = new ManufactureRepository($manufactureFactory);
        $deletedTrash = $manufactureRepo->trashManufacture();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('manufactures', ['id' => $manufactureFactory->getKey()]);

        $restored = $manufactureRepo->restoreManufacture();
        $this->assertTrue($restored);
        $this->assertDatabaseHas('manufactures', ['id' => $manufactureFactory->getKey()]);
    }

    public function test_can_update_the_manufacture(): void
    {
        $manufactureFactory = ManufactureFactory::new()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $manufactureRepo = new ManufactureRepository($manufactureFactory);
        $updated = $manufactureRepo->updateManufacture($data);

        $manufacture = $manufactureRepo->getManufacture($manufactureFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $manufacture->name);
    }

    public function test_can_create_a_manufacture(): void
    {
        $data = [
            'name' => $this->faker->name,
        ];

        $manufactureRepo = new ManufactureRepository(new Manufacture);
        $manufacture = $manufactureRepo->createManufacture($data);

        $this->assertInstanceOf(Manufacture::class, $manufacture);
        $this->assertEquals($data['name'], $manufacture->name);
    }

    public function test_errors_creating_the_manufacture(): void
    {
        $this->expectException(Exception::class);

        $manufactureRepo = new ManufactureRepository(new Manufacture);
        $manufactureRepo->createManufacture([]);
    }

    public function test_manufacture_has_relation_with_products(): void
    {
        $manufacture = ManufactureFactory::new()->create();
        $manufacture->products()->saveMany(ProductFactory::new()->count(5)->create([
            'brand_id' => BrandFactory::new()->create()->getKey(),
            'supplier_id' => SupplierFactory::new()->create()->getKey(),
            'category_id' => CategoryFactory::new()->create()->getKey(),
        ]));

        $this->assertInstanceOf(Manufacture::class, $manufacture);
        $this->assertInstanceOf(Collection::class, $manufacture->products);
        $this->assertInstanceOf(Product::class, $manufacture->products[0]);
    }
}
