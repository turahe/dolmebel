<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Database\Factories\PriceFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Turahe\Core\Enums\OrganizationType;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brand = fake()->randomElement(Brand::pluck('id')->toArray());
        $supplier = fake()->randomElement(Supplier::where('type', OrganizationType::Company)->pluck('id')->toArray());
        $categories = Category::all();

        foreach ($categories as $category) {
            ProductFactory::new()->count(mt_rand(10, 30))->create([
                'brand_id' => $brand,
                'supplier_id' => $supplier,
                'category_id' => $category->getKey(),
            ])->each(function (Product $product): void {
                $product->setContents(fake()->text);
                $product->prices()->saveMany(PriceFactory::new()->count(3)->make());
                $product->attachTags([fake()->word, fake()->word], 'product');
            });
        }

    }
}
