<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Shop;
use App\Models\User;
use App\Repositories\ShopRepository;
use Database\Factories\ShopFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;
use Turahe\Core\Enums\OrganizationType;
use Turahe\Media\MediaUploader;

class ShopTest extends TestCase
{
    public function test_can_list_all_shops(): void
    {
        $count = 5;
        ShopFactory::new()->count($count)->create();

        $shopRepo = new ShopRepository(new Shop);
        $shops = $shopRepo->getShops();

        $this->assertInstanceOf(Collection::class, $shops);
        $this->assertCount($count, $shops->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_shop(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $shopRepo = new ShopRepository(new Shop);
        $shopRepo->getIdShop('121323');

    }

    public function test_can_force_delete_the_shop(): void
    {
        $shop = ShopFactory::new()->create(['type' => OrganizationType::Store]);

        $shopRepo = new ShopRepository($shop);
        $deleted = $shopRepo->deleteShop();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('organizations', []);
    }

    public function test_can_delete_the_shop(): void
    {
        $shop = ShopFactory::new()->create(['type' => OrganizationType::Store]);

        $shopRepo = new ShopRepository($shop);
        $deletedTrash = $shopRepo->trashShop();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('organizations', ['id' => $shop->getKey()]);
    }

    public function test_can_update_the_shop(): void
    {
        $shopFactory = ShopFactory::new()->create(['type' => OrganizationType::Store]);

        $data = [
            'name' => $this->faker->company,
            'code' => $this->faker->randomNumber(9),
        ];

        $shopRepo = new ShopRepository($shopFactory);
        $updated = $shopRepo->updateShop($data);

        $shop = $shopRepo->getIdShop($shopFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $shop->name);
        $this->assertEquals($data['code'], $shop->code);
        $this->assertEquals(OrganizationType::Store, $shop->type);
    }

    public function test_can_create_a_shop(): void
    {
        $user = UserFactory::new()->createOne();
        $this->actingAs($user);
        $data = [
            'name' => $this->faker->company,
            'code' => $this->faker->randomNumber(9),
        ];

        $shopRepo = new ShopRepository(new Shop);
        $shop = $shopRepo->createShop($data);

        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertEquals($data['name'], $shop->name);
        $this->assertEquals($data['code'], $shop->code);
        $this->assertEquals(Str::slug($data['name']), $shop->slug);
        $this->assertEquals(OrganizationType::Store, $shop->type);
    }

    public function test_can_create_a_shop_with_logo(): void
    {
        $user = UserFactory::new()->createOne();
        $this->actingAs($user);
        $data = [
            'name' => $this->faker->company,
            'code' => $this->faker->randomNumber(9),
            'logo' => UploadedFile::fake()->image('logo.png', 200, 200),
        ];

        $shopRepo = new ShopRepository(new Shop);
        $shop = $shopRepo->createShop($data);
        $media = MediaUploader::fromFile($data['logo'])->upload();
        $shop->attachMedia($media);

        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertEquals($data['name'], $shop->name);
        $this->assertEquals($data['code'], $shop->code);
        $this->assertEquals(Str::slug($data['name']), $shop->slug);
        $this->assertEquals(OrganizationType::Store, $shop->type);
    }

    public function test_errors_creating_the_shop(): void
    {
        $this->expectException(\Exception::class);

        $shopRepo = new ShopRepository(new Shop);
        $shopRepo->createShop([]);
    }

    public function test_model_shop_has_relation_with_users(): void
    {
        $users = UserFactory::new()->count(5)->create();
        $user = UserFactory::new()->createOne();
        $this->actingAs($user);
        $shop = ShopFactory::new()->create();

        $shop->users()->attach($users, [
            'role' => 'MEMBER',
        ]);

        $this->assertCount(5, $shop->users);
        $this->assertInstanceOf(Collection::class, $shop->allUsers());
        $this->assertInstanceOf(Collection::class, $shop->users);
        $this->assertInstanceOf(User::class, $shop->author);
        $this->assertInstanceOf(User::class, $shop->users->first());
        $this->assertInstanceOf(MorphToMany::class, $shop->users());
        $this->assertEquals($users->first()->getKey(), $shop->users->first()->getKey());
        $this->assertEquals($users->first()->username, $shop->users->first()->username);
        $this->assertEquals($users->first()->email, $shop->users->first()->email);
        $this->assertEquals($users->first()->phone, $shop->users->first()->phone);

    }
}
