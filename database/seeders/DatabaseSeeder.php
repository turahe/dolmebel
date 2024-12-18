<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Turahe\Master\Seeds\LanguagesTableSeeder::class,
            \Turahe\Master\Seeds\CountriesTableSeeder::class,
            \Turahe\Master\Seeds\CurrenciesTableSeeder::class,
            \Turahe\Master\Seeds\BanksTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserTableSeeder::class,
            OrganizationTableSeeder::class,
            CategoryTableSeeder::class,
            PostsTableSeeder::class,
            ProductsTableSeeder::class,
            ServicesTableSeeder::class,

        ]);

    }

    private array $defaultUser = [
        [
            'username' => 'admin',
            'role' => 'admin',
        ],
        [
            'username' => 'user',
            'role' => 'user',
        ]
    ];
}
