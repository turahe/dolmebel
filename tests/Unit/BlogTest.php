<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\Media;
use App\Repositories\BlogRepository;
use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Turahe\Media\MediaUploader;

class BlogTest extends \Tests\TestCase
{
    public function test_can_list_all_blogs(): void
    {
        $count = 5;
        BlogFactory::new()->count($count)->create();

        $blogRepo = new BlogRepository(new Blog);
        $blogs = $blogRepo->getBlogs();

        $this->assertInstanceOf(Collection::class, $blogs);
        $this->assertCount($count, $blogs->all()); // +1 in the TestCase
    }

    public function test_can_force_delete_the_blog(): void
    {
        $blog = BlogFactory::new()->createOne();

        $blogRepo = new BlogRepository($blog);
        $deleted = $blogRepo->deleteBlog();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing(config('post.tables.posts'), []);
    }

    public function test_can_delete_the_blog(): void
    {
        $blog = BlogFactory::new()->createOne();

        $blogRepo = new BlogRepository($blog);
        $deletedTrash = $blogRepo->trashBlog();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted(config('post.tables.posts'), ['id' => $blog->getKey()]);
    }

    public function test_can_delete_all_trash_in_the_blog(): void
    {
        BlogFactory::new()->count(13)->create();

        Blog::all()->each(function (Blog $blog) {
            $blog->delete();
        });

        $blogRepo = new BlogRepository(new Blog);
        $emptyTrash = $blogRepo->emptyTrash();

        $this->assertTrue($emptyTrash);
        $this->assertDatabaseMissing(config('post.tables.posts'));
    }

    public function test_cannot_delete_all_trash_in_the_blog(): void
    {
        BlogFactory::new()->count(13)->create();

        $blogRepo = new BlogRepository(new Blog);
        $emptyTrash = $blogRepo->emptyTrash();

        $this->assertFalse($emptyTrash);
        $this->assertDatabaseHas(config('post.tables.posts'), []);
    }

    public function test_cannot_get_the_blog(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $blogRepo = new BlogRepository(new Blog);
        $blogRepo->getBlog('not-a-blog');

    }

    public function test_can_get_the_blog(): void
    {
        $blogFactory = BlogFactory::new()->createOne();

        $blogRepo = new BlogRepository($blogFactory);
        $blog = $blogRepo->getBlog($blogFactory->slug);

        $this->assertInstanceOf(Blog::class, $blog);
    }

    public function test_can_update_the_blog(): void
    {
        $blogFactory = BlogFactory::new()->createOne();

        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $blogRepo = new BlogRepository($blogFactory);
        $updated = $blogRepo->updateBlog($data);

        $blog = $blogRepo->getBlog($blogFactory->slug);

        $this->assertTrue($updated);
        $this->assertEquals($data['title'], $blog->title);
        $this->assertEquals($data['description'], $blog->description);
        $this->assertEquals($data['subtitle'], $blog->subtitle);
        $this->assertEquals('blog', $blog->type);
    }

    public function test_can_create_a_blog(): void
    {
        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->paragraph,
        ];

        $blogRepo = new BlogRepository(new Blog);
        $blog = $blogRepo->createBlog($data);

        $this->assertInstanceOf(Blog::class, $blog);
        $this->assertEquals($data['title'], $blog->title);
        $this->assertEquals($data['description'], $blog->description);
        $this->assertEquals($data['subtitle'], $blog->subtitle);
        $this->assertEquals($data['content'], $blog->content_raw);
        $this->assertEquals('blog', $blog->type);
    }

    public function test_errors_creating_the_blog(): void
    {
        $this->expectException(\Exception::class);

        $blogRepo = new BlogRepository(new Blog);
        $blogRepo->createBlog([]);
    }

    public function test_blog_has_image(): void
    {
        $blog = BlogFactory::new()->createOne();

        $file = UploadedFile::fake()->image('image.png', 600, 600);

        $media = MediaUploader::fromFile($file)->upload();
        $exists = Storage::disk('public')->exists($media->getPath());
        $blog->attachMedia($media, 'image');

        $this->assertInstanceOf(Media::class, $media);
        $this->assertDatabaseHas('media', [
            'id' => $media->getKey(),
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
        ]);

        $this->assertEquals($blog->image, Storage::disk('public')->exists($media->getPath()));

        $this->assertTrue($exists);

    }
}
