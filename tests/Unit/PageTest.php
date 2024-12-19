<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Page;
use App\Repositories\PageRepository;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class PageTest extends TestCase
{
    public function test_can_list_all_pages(): void
    {
        $count = 5;
        PageFactory::new()->count($count)->create();

        $pageRepo = new PageRepository(new Page);
        $pages = $pageRepo->getPages();

        $this->assertInstanceOf(Collection::class, $pages);
        $this->assertCount($count, $pages->all()); // +1 in the TestCase
    }

    public function test_can_force_delete_the_page(): void
    {
        $page = PageFactory::new()->create();

        $pageRepo = new PageRepository($page);
        $deleted = $pageRepo->deletePage();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('posts', []);
    }

    public function test_cannot_get_the_page(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $pageRepo = new PageRepository(new Page);
        $pageRepo->getPageBySlug('slug-page');

    }

    public function test_can_delete_the_page(): void
    {
        $page = PageFactory::new()->create();

        $pageRepo = new PageRepository($page);
        $deletedTrash = $pageRepo->trashPage();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('posts', ['id' => $page->getKey()]);
    }

    public function test_can_update_the_page(): void
    {
        $pageFactory = PageFactory::new()->create();

        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => 'page',
        ];

        $pageRepo = new PageRepository($pageFactory);
        $updated = $pageRepo->updatePage($data);

        $comment = $pageRepo->getPageBySlug($pageFactory->slug);

        $this->assertTrue($updated);
        $this->assertEquals($data['title'], $comment->title);
        $this->assertEquals($data['description'], $comment->description);
        $this->assertEquals($data['subtitle'], $comment->subtitle);
        $this->assertEquals($data['type'], $comment->type);
    }

    public function test_can_create_a_page(): void
    {
        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->paragraph,
            'type' => 'page',
        ];

        $pageRepo = new PageRepository(new Page);
        $comment = $pageRepo->createPage($data);

        $this->assertInstanceOf(Page::class, $comment);
        $this->assertEquals($data['title'], $comment->title);
        $this->assertEquals($data['description'], $comment->description);
        $this->assertEquals($data['subtitle'], $comment->subtitle);
        $this->assertEquals($data['content'], $comment->content_raw);
        $this->assertEquals($data['type'], $comment->type);
    }

    public function test_errors_creating_the_page(): void
    {
        $this->expectException(\Exception::class);

        $pageRepo = new PageRepository(new Page);
        $pageRepo->createPage([]);
    }

    public function test_can_find_slug_a_page(): void
    {
        $data = [
            'slug' => 'page-1',
            'title' => 'Page 1',
        ];
        $page = PageFactory::new()->create($data);

        $pageRepo = new PageRepository($page);

        $found = $pageRepo->getPageBySlug($data['slug']);

        $this->assertInstanceOf(Page::class, $found);
        $this->assertEquals($page['slug'], $found->slug);
        $this->assertEquals($page['title'], $found->title);
    }
}
