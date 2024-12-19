<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ManufactureFactory;
use Database\Factories\ProductFactory;
use Database\Factories\SupplierFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Turahe\Media\MediaUploader;

class ProductTest extends TestCase
{
    protected $brand;

    protected $product;

    protected $supplier;

    protected $manufacture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->brand = BrandFactory::new()->createOne();
        $this->category = CategoryFactory::new()->createOne();
        $this->supplier = SupplierFactory::new()->createOne();
        $this->manufacture = ManufactureFactory::new()->createOne();
    }

    public function test_can_list_all_products(): void
    {
        $count = 5;
        ProductFactory::new()->count($count)->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $productRepo = new ProductRepository(new Product);
        $products = $productRepo->getProducts();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertCount($count, $products->all());
        $products->each(function (Product $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertDatabaseHas('products', [
                'brand_id' => $this->brand->getKey(),
                'supplier_id' => $this->supplier->getKey(),
                'category_id' => $this->category->getKey(),
            ]);
        });
    }

    public function test_cannot_get_the_product(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $productRepo = new ProductRepository(new Product);
        $productRepo->getProductBySlug('slug-page');
        $productRepo->getProduct('1234');

    }

    public function test_can_force_delete_the_product(): void
    {
        $product = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $productRepo = new ProductRepository($product);
        $deleted = $productRepo->deleteProduct();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('products', []);
        $this->assertNotNull($product);
    }

    public function test_can_delete_the_product(): void
    {
        $product = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $productRepo = new ProductRepository($product);
        $deletedTrash = $productRepo->trashProduct();

        $this->assertTrue($deletedTrash);
        $this->assertSoftDeleted('products', ['id' => $product->getKey()]);
        $this->assertNotNull($product);
    }

    public function test_can_update_the_product(): void
    {
        $productFactory = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $data = [
            'qrcode' => $this->faker->uuid,
            'barcode' => $this->faker->uuid,
        ];

        $productRepo = new ProductRepository($productFactory);
        $updated = $productRepo->updateProduct($data);

        $product = $productRepo->getProduct($productFactory->getKey());

        $this->assertTrue($updated);
        $this->assertEquals($data['qrcode'], $product->qrcode);
        $this->assertEquals($data['barcode'], $product->barcode);
    }

    public function test_can_create_a_product(): void
    {
        $data = [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->paragraph(5),
            'qrcode' => $this->faker->uuid,
            'barcode' => $this->faker->uuid,
            'supplier_id' => $this->supplier->getKey(),
            'manufacture_id' => $this->manufacture->getKey(),
            'brand_id' => $this->brand->getKey(),
            'category_id' => $this->category->getKey(),
        ];

        $productRepo = new ProductRepository(new Product);
        $product = $productRepo->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertInstanceOf(Brand::class, $product->brand);
        //        $this->assertInstanceOf(Manufacture::class, $product->manufacture);
        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($data['qrcode'], $product->qrcode);
        $this->assertEquals($data['barcode'], $product->barcode);
        $this->assertEquals($data['supplier_id'], $product->supplier_id);
        //        $this->assertEquals($data['manufacture_id'], $product->manufacture_id);
        $this->assertEquals($data['brand_id'], $product->brand_id);
    }

    public function test_errors_creating_the_product(): void
    {
        $this->expectException(Exception::class);

        $productRepo = new ProductRepository(new Product);
        $productRepo->createProduct([]);
    }

    public function test_return_empty_products_collection_when_eloquent_has_no_manufacture(): void
    {
        $product = ProductFactory::new()->createOne([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $this->assertEmpty($product->manufacture);

    }

    public function test_product_has_thumbnail(): void
    {
        $product = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);

        $file = UploadedFile::fake()->image('thumbnail.png', 600, 600);

        $media = MediaUploader::fromFile($file)->upload();
        $exists = Storage::disk('public')->exists($media->getPath());
        $product->attachMedia($media);

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

    public function test_can_return_the_product_of_the_cover_image()
    {
        $thumbnails = [
            UploadedFile::fake()->image('cover1.png', 600, 600),
            UploadedFile::fake()->image('cover2.png', 600, 600),
            UploadedFile::fake()->image('cover3.png', 600, 600),
        ];

        $collection = collect($thumbnails);

        $product = ProductFactory::new()->create([
            'brand_id' => $this->brand->getKey(),
            'supplier_id' => $this->supplier->getKey(),
            'category_id' => $this->category->getKey(),
        ]);
        $productRepo = new ProductRepository($product);
        $productRepo->saveProductImages($collection);

        $images = $productRepo->findProductImages();

        $images->each(function (Media $image) {
            $this->assertInstanceOf(Media::class, $image);
            $this->assertDatabaseHas('media', [
                'id' => $image->getKey(),
                'name' => $image->name,
                'file_name' => $image->file_name,
                'mime_type' => $image->mime_type,
                'size' => $image->size,
            ]);
        });
    }
}
