<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Media;
use App\Repositories\BrandRepository;
use Database\Factories\BrandFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Turahe\Media\MediaUploader;

class BrandTest extends \Tests\TestCase
{
    public function test_can_list_all_brands(): void
    {
        BrandFactory::new()->count(6)->create();

        $brandRepo = new BrandRepository(new Brand);
        $brands = $brandRepo->getBrands();

        $this->assertInstanceOf(Collection::class, $brands);
        $this->assertCount(6, $brands->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_brand(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $brandRepo = new BrandRepository(new Brand);
        $brandRepo->getBrand('not-a-brand');

    }

    public function test_can_force_delete_the_brand(): void
    {
        $brandFactory = BrandFactory::new()->createOne();

        $brandRepo = new BrandRepository($brandFactory);
        $deleted = $brandRepo->deleteBrand();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('brands', []);
    }

    public function test_can_delete_the_brand(): void
    {
        $brandFactory = BrandFactory::new()->createOne();

        $brandRepo = new BrandRepository($brandFactory);
        $deletedTrash = $brandRepo->trashBrand();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('brands', ['id' => $brandFactory->getKey()]);
    }

    public function test_can_update_the_brand(): void
    {
        $brandFactory = BrandFactory::new()->createOne();

        $data = [
            'name' => $this->faker->company,
        ];

        $brandRepo = new BrandRepository($brandFactory);
        $updated = $brandRepo->updateBrand($data);

        $brand = $brandRepo->getBrand($brandFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $brand->name);
    }

    public function test_can_create_a_brand(): void
    {
        $data = [
            'name' => $this->faker->company,
        ];

        $brandRepo = new BrandRepository(new Brand);
        $brand = $brandRepo->createBrand($data);

        $this->assertInstanceOf(Brand::class, $brand);
        $this->assertEquals($data['name'], $brand->name);
    }

    public function test_errors_creating_the_brand(): void
    {
        $this->expectException(Exception::class);

        $brandRepo = new BrandRepository(new Brand);
        $brandRepo->createBrand([]);
    }

    public function test_brand_has_relation(): void
    {
        $brand = BrandFactory::new()->createOne();

        $this->assertInstanceOf(Brand::class, $brand);
    }

    public function test_brand_has_logo(): void
    {
        $brand = BrandFactory::new()->createOne();

        $file = UploadedFile::fake()->image('logo.png', 600, 600);

        $media = MediaUploader::fromFile($file)->upload();
        $exists = Storage::disk('public')->exists($media->getPath());
        $brand->attachMedia($media);

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
}
