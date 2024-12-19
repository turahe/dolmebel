<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Database\Factories\SupplierFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Turahe\Core\Enums\OrganizationType;

class SupplierTest extends TestCase
{
    public function test_return_empty_suppliers_collection_when_eloquent_has_no_suppliers(): void
    {
        $user = UserFactory::new()->createOne();

        $this->assertEmpty($user->organizations);

    }

    public function test_can_list_all_suppliers(): void
    {
        $count = 5;
        SupplierFactory::new()->count($count)->create();

        $orgRepo = new SupplierRepository(new Supplier);
        $suppliers = $orgRepo->getSuppliers();

        $this->assertInstanceOf(Collection::class, $suppliers);
        $this->assertCount($count, $suppliers->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_supplier(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $supplierRepo = new SupplierRepository(new Supplier);
        $supplierRepo->getSupplier('121323');

    }

    public function test_can_force_delete_the_supplier(): void
    {
        $organization = SupplierFactory::new()->createOne();

        $orgRepo = new SupplierRepository($organization);
        $deleted = $orgRepo->deleteSupplier();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('organizations', []);
    }

    public function test_can_delete_the_supplier(): void
    {
        $organization = SupplierFactory::new()->createOne();

        $orgRepo = new SupplierRepository($organization);
        $deletedTrash = $orgRepo->trashSupplier();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('organizations', ['id' => $organization->getKey()]);
    }

    public function test_can_update_the_supplier(): void
    {
        $organizationFactory = SupplierFactory::new()->createOne();

        $data = [
            'name' => $this->faker->company,
            'code' => $this->faker->randomNumber(9),
            'type' => OrganizationType::Supplier,
        ];

        $orgRepo = new SupplierRepository($organizationFactory);
        $updated = $orgRepo->updateSupplier($data);

        $org = $orgRepo->getSupplierBySlug($organizationFactory->slug);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $org->name);
        $this->assertEquals($data['code'], $org->code);
        $this->assertEquals($data['type'], $org->type);
    }

    public function test_can_create_a_supplier(): void
    {
        $data = [
            'name' => $this->faker->company,
            'code' => $this->faker->randomNumber(9),
        ];

        $orgRepo = new SupplierRepository(new Supplier);
        $org = $orgRepo->createSupplier($data);

        $this->assertInstanceOf(Supplier::class, $org);
        $this->assertEquals($data['name'], $org->name);
        $this->assertEquals($data['code'], $org->code);
        $this->assertEquals(OrganizationType::Supplier, $org->type);
    }

    public function test_errors_creating_the_supplier(): void
    {
        $this->expectException(\Exception::class);

        $orgRepo = new SupplierRepository(new Supplier);
        $orgRepo->createSupplier([]);
    }
}
