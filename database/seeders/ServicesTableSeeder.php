<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Database\Factories\PriceFactory;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceFactory::new()->count(30)->create()->each(function (Service $service): void {
            $service->setContents(fake()->text);
            $service->prices()->saveMany(PriceFactory::new()->count(3)->make());
            $service->attachTags([fake()->word, fake()->word], 'service');
        });
    }
}
