<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        foreach ($this->defaultCategories as $data) {
            Category::create($data);
        }
        //        Category::create($this->defaultCategories);
    }

    private array $defaultCategories = [
        [
            'name' => 'Bedroom',
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
    ];
}
