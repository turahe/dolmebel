<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Faq;
use App\Repositories\FaqRepository;
use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class FaqTest extends TestCase
{
    public function test_can_list_all_faqs(): void
    {
        $count = 5;
        FaqFactory::new()->count($count)->create();

        $faqRepo = new FaqRepository(new Faq);
        $faqs = $faqRepo->getFaqs();

        $this->assertInstanceOf(Collection::class, $faqs);
        $this->assertCount($count, $faqs->all()); // +1 in the TestCase
    }

    public function test_cannot_get_the_faq(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $faqRepo = new FaqRepository(new Faq);
        $faqRepo->getIdFaq('not-a-faq');

    }

    public function test_can_force_delete_the_faq(): void
    {
        $faq = FaqFactory::new()->createOne();

        $faqRepo = new FaqRepository($faq);
        $deleted = $faqRepo->deleteFaq();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('posts', []);
    }

    public function test_can_delete_the_faq(): void
    {
        $faq = FaqFactory::new()->createOne();

        $faqRepo = new FaqRepository($faq);
        $deletedTrash = $faqRepo->trashFaq();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('posts', ['id' => $faq->getKey()]);
    }

    public function test_can_update_the_faq(): void
    {
        $faqFactory = FaqFactory::new()->createOne();

        $data = [
            'question' => $this->faker->sentence,
            'answer' => $this->faker->paragraph,
            'language' => $this->faker->languageCode,
        ];

        $faqRepo = new FaqRepository($faqFactory);
        $updated = $faqRepo->updateFaq($data);

        $faq = $faqRepo->getIdFaq($faqFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['question'], $faq->question);
        $this->assertEquals($data['answer'], $faq->answer);
        $this->assertEquals($data['language'], $faq->language);
    }

    public function test_can_create_a_faq(): void
    {
        $data = [
            'question' => $this->faker->sentence,
            'answer' => $this->faker->paragraph,
            'language' => $this->faker->languageCode,
        ];

        $faqRepo = new FaqRepository(new Faq);
        $faq = $faqRepo->createFaq($data);

        $this->assertInstanceOf(Faq::class, $faq);
        $this->assertEquals($data['question'], $faq->question);
        $this->assertEquals($data['answer'], $faq->answer);
        $this->assertEquals($data['language'], $faq->language);
    }

    public function test_errors_creating_the_faq(): void
    {
        $this->expectException(\Exception::class);

        $faqRepo = new FaqRepository(new Faq);
        $faqRepo->createFaq([]);
    }
}
