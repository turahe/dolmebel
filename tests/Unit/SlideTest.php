<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Media;
use App\Models\Slide;
use App\Repositories\SlideRepository;
use Database\Factories\SlideFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Turahe\Media\MediaUploader;

class SlideTest extends TestCase
{
    public function test_can_list_all_slides(): void
    {
        $count = 5;
        SlideFactory::new()->count($count)->create([
            'type' => 'slide',
        ]);

        $slideRepo = new SlideRepository(new Slide);
        $slides = $slideRepo->getSlides();

        $this->assertInstanceOf(Collection::class, $slides);
        $this->assertCount($count, $slides->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_slide(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $slideRepo = new SlideRepository(new Slide);
        $slideRepo->getSlide('121323');

    }

    public function test_can_force_delete_the_slide(): void
    {
        $slide = SlideFactory::new()->createOne();

        $slideRepo = new SlideRepository($slide);
        $deleted = $slideRepo->deleteSlide();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('posts', []);
    }

    public function test_can_delete_the_slide(): void
    {
        $slide = SlideFactory::new()->createOne();

        $slideRepo = new SlideRepository($slide);
        $deletedTrash = $slideRepo->trashSlide();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('posts', ['id' => $slide->getKey()]);
    }

    public function test_can_update_the_slide(): void
    {
        $slideFactory = SlideFactory::new()->createOne();

        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => 'slide',
        ];

        $slideRepo = new SlideRepository($slideFactory);
        $updated = $slideRepo->updateSlide($data);

        $slide = $slideRepo->getSlide($slideFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['title'], $slide->title);
        $this->assertEquals($data['description'], $slide->description);
        $this->assertEquals($data['subtitle'], $slide->subtitle);
        $this->assertEquals($data['type'], $slide->type);
    }

    public function test_can_create_a_slide(): void
    {
        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => 'slide',
        ];

        $slideRepo = new SlideRepository(new Slide);
        $slide = $slideRepo->createSlide($data);

        $this->assertInstanceOf(Slide::class, $slide);
        $this->assertEquals($data['title'], $slide->title);
        $this->assertEquals($data['description'], $slide->description);
        $this->assertEquals($data['subtitle'], $slide->subtitle);
        $this->assertEquals($data['type'], $slide->type);
    }

    public function test_errors_creating_the_slide(): void
    {
        $this->expectException(\Exception::class);

        $slideRepo = new SlideRepository(new Slide);
        $slideRepo->createSlide([]);
    }

    public function test_slide_has_image(): void
    {
        $slide = SlideFactory::new()->createOne();

        $file = UploadedFile::fake()->image('image.png', 600, 600);

        $media = MediaUploader::fromFile($file)->upload();
        $exists = Storage::disk('public')->exists($media->getPath());
        $slide->attachMedia($media, 'image');

        $this->assertInstanceOf(Media::class, $media);
        $this->assertDatabaseHas('media', [
            'id' => $media->getKey(),
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
        ]);

        $this->assertEquals($slide->image, Storage::disk('public')->exists($media->getPath()));

        $this->assertTrue($exists);

    }
}
