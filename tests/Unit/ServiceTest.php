<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Database\Factories\CategoryFactory;
use Database\Factories\ServiceFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = CategoryFactory::new()->createOne();
    }

    public function test_can_list_all_services(): void
    {
        $count = 5;
        ServiceFactory::new()->count($count)->create([
            'category_id' => $this->category->getKey(),
        ]);

        $serviceRepo = new ServiceRepository(new Service);
        $services = $serviceRepo->getServices();

        $this->assertInstanceOf(Collection::class, $services);
        $this->assertCount($count, $services->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_service(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $serviceRepo = new ServiceRepository(new Service);
        $serviceRepo->getService('121323');

    }

    public function test_can_force_delete_the_service(): void
    {
        $service = ServiceFactory::new()->createOne([
            'category_id' => $this->category->getKey(),
        ]);

        $serviceRepo = new ServiceRepository($service);
        $deleted = $serviceRepo->deleteService();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('services', []);
    }

    public function test_can_delete_the_service(): void
    {
        $service = ServiceFactory::new()->createOne([
            'category_id' => $this->category->getKey(),
        ]);

        $serviceRepo = new ServiceRepository($service);
        $deletedTrash = $serviceRepo->trashService();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('services', ['id' => $service->getKey()]);
    }

    public function test_can_update_the_service(): void
    {
        $serviceFactory = ServiceFactory::new()->createOne([
            'category_id' => $this->category->getKey(),
        ]);

        $data = [
            'code' => $this->faker->uuid,
        ];

        $serviceRepo = new ServiceRepository($serviceFactory);
        $updated = $serviceRepo->updateService($data);

        $service = $serviceRepo->getService($serviceFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['code'], $service->code);
    }

    public function test_can_create_a_service(): void
    {

        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'code' => $this->faker->uuid,
            'category_id' => $this->category->getKey(),
        ];

        $serviceRepo = new ServiceRepository(new Service);
        $service = $serviceRepo->createService($data);

        $this->assertInstanceOf(Service::class, $service);
        $this->assertInstanceOf(Category::class, $service->category);
        $this->assertEquals($data['code'], $service->code);
    }

    public function test_errors_creating_the_service(): void
    {
        $this->expectException(Exception::class);

        $serviceRepo = new ServiceRepository(new Service);
        $serviceRepo->createService([]);
    }

    public function test_return_empty_services_collection_when_eloquent_has_no_category(): void
    {
        $service = ServiceFactory::new()->createOne([
            'category_id' => $this->category->getKey(),
        ]);

        $this->assertInstanceOf(Category::class, $service->category);

    }
}
