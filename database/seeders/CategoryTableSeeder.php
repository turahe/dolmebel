<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Media::truncate();

        foreach ($this->defaultCategories as $data) {
            $category = Category::create($data);
            $pathImage = storage_path('app/assets/images/categories/'.$category->slug.'.png');
            if (File::exists($pathImage)) {
                $this->uploadAsset($category, $pathImage, 'image');
            }
            $pathIcon = storage_path('app/assets/icons/'.$category->slug.'.svg');
            if (File::exists($pathIcon)) {
                $this->uploadAsset($category, $pathIcon, 'icon');
            }

        }
    }

    private array $defaultCategories = [
        [
            'name' => 'Bedroom',
            'children' => [
                [
                    'name' => 'Beds',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
                [
                    'name' => 'Lamps',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
                [
                    'name' => 'Bedside Tables',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
                [
                    'name' => 'Specials',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],

        ],
        [
            'name' => 'Matrass',
            'children' => [
                [
                    'name' => 'Bar',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Sofa',
            'children' => [
                [
                    'name' => 'Bar',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Kitchen',
            'children' => [
                [
                    'name' => 'Bar',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Living Room',
            'children' => [
                [
                    'name' => 'Bar',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Outdoors',
            'children' => [
                [
                    'name' => 'Bar',

                    'children' => [
                        ['name' => 'Baz'],
                    ],
                ],
            ],
        ],
    ];

    private function uploadAsset(Category $category, string $pathIcon, string $group): void
    {
        $media = Media::create([
            'name' => $category->name,
            'file_name' => $category->slug.'.png',
            'disk' => config('filesystems.default'),
            'mime_type' => 'image/png',
            'size' => filesize($pathIcon),
        ]);
        Storage::disk($media->disk)->putFileAs($media->getKey(), $pathIcon, $media->file_name);
        $category->attachMedia($media, $group);
    }
}
