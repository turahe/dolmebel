<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Media;
use App\Models\User;
use App\Repositories\UserRepository;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Turahe\Core\Enums\OrganizationType;
use Turahe\Core\Models\Organization;
use Turahe\Master\Seeds\LanguagesTableSeeder;
use Turahe\Media\MediaUploader;

class UserTest extends TestCase
{
    public function test_return_empty_organizations_collection_when_eloquent_has_no_organizations(): void
    {
        $user = UserFactory::new()->createOne();

        $this->assertEmpty($user->organizations);

    }

    public function test_cannot_get_the_user(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $userRepo = new UserRepository(new User);
        $userRepo->getId('121323');
        $userRepo->getUsername('user.name');
        $userRepo->getPhone('085343432432');
        $userRepo->getEmail('eamil@example.com');

    }

    public function test_can_create_the_user(): void
    {
        Event::fake(
            Registered::class,
        );
        $this->seed(LanguagesTableSeeder::class);
        $data = [
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->countryCode,
            'password' => $this->faker->password(),
        ];

        $userRepo = new UserRepository(new User);
        $user = $userRepo->createUser($data);
        Event::assertDispatched(Registered::class);

        $this->assertEquals($data['username'], $user->username);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals(parse_phone($data['phone'], $data['country']), $user->phone);
    }

    public function test_can_delete_a_user(): void
    {
        $userFactory = UserFactory::new()->create();
        $userRepo = new UserRepository($userFactory);
        $deleted = $userRepo->trash();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted('users', [
            'id' => $userFactory->getKey(),
            'username' => $userFactory->username,
            'email' => $userFactory->email,
            'phone' => $userFactory->phone,
        ]);
    }

    public function test_can_restore_after_delete_the_user(): void
    {
        $userFactory = UserFactory::new()->create();
        $userRepo = new UserRepository($userFactory);
        $deleted = $userRepo->trash();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted('users', ['id' => $userFactory->getKey()]);

        $restored = $userRepo->restore();
        $this->assertTrue($restored);
        $this->assertDatabaseHas('users', ['id' => $userFactory->getKey()]);
    }

    public function test_can_force_delete_a_user(): void
    {
        $userFactory = UserFactory::new()->create();
        $userRepo = new UserRepository($userFactory);
        $deleted = $userRepo->deleteUser();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', []);
    }

    public function test_can_empty_trash_a_user(): void
    {
        $users = UserFactory::new()->count(13)->create();
        $userRepo = new UserRepository(new User);
        $users->each(function ($user) {
            $user->delete();
        });
        $deleted = $userRepo->emptyTrash();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', []);
    }

    public function test_can_mas_destroy_a_user(): void
    {
        $users = UserFactory::new()->count(13)->create();
        $userRepo = new UserRepository(new User);
        $deleted = $userRepo->massDestroy($users->pluck('id')->toArray());

        $this->assertTrue($deleted);
        $this->assertSoftDeleted('users', []);
    }

    public function test_errors_when_updating_the_user(): void
    {
        $userFactory = UserFactory::new()->create();

        $userRepo = new UserRepository($userFactory);
        $this->expectException(Exception::class);

        $userRepo->updateUser(['username' => null]);
    }

    public function test_can_update_the_user(): void
    {
        $userFactory = UserFactory::new()->create();

        $update = ['username' => 'username'];
        $userRepo = new UserRepository($userFactory);
        $updated = $userRepo->updateUser($update);

        $user = $userRepo->getUsername($update['username']);

        $this->assertTrue($updated);
        $this->assertEquals($update['username'], $user->username);
    }

    public function test_can_find_the_user(): void
    {
        $user = UserFactory::new()->create([
            'phone' => $this->faker->phoneNumber(),
        ]);

        $userRepo = new UserRepository($user);
        $getUserId = $userRepo->getId($user->id);
        $getUserEmail = $userRepo->getEmail($user->email);
        $getUserUsername = $userRepo->getUsername($user->username);
        $getPhone = $userRepo->getPhone($user->phone);

        $this->assertEquals($user->id, $getUserId->id);
        $this->assertEquals($user->username, $getUserUsername->username);
        $this->assertEquals($user->email, $getUserEmail->email);
        $this->assertEquals($user->phone, $getPhone->phone);

    }

    public function test_user_has_avatar(): void
    {
        $user = UserFactory::new()->create();

        $file = UploadedFile::fake()->image('avatar.png', 600, 600);

        $media = MediaUploader::fromFile($file)->upload();
        $exists = Storage::disk('public')->exists($media->getPath());
        $user->attachMedia($media);

        $this->assertInstanceOf(Media::class, $media);
        $this->assertDatabaseHas('media', [
            'id' => $media->getKey(),
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
        ]);

        $this->assertTrue($exists);

    }

    public function test_can_set_active_workspace(): void
    {
        $user = UserFactory::new()->createOne();
        $organization = Organization::create(['name' => $this->faker->company, 'type' => OrganizationType::Company]);
        $user->setActiveWorkspace($organization);
        $this->assertInstanceOf(Organization::class, $user->organizations->first());
        $this->assertDatabaseHas('settings', [
            'model_type' => $user->getMorphClass(),
            'model_id' => $user->getKey(),
            'key' => 'active_workspace',
            'value' => $organization->getKey(),
        ]);
    }

    public function test_can_list_all_users(): void
    {
        $users = UserFactory::new()->count(3)->create();

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(3, $users->all());
    }
}
