<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\OrganizationType;
use App\Enums\PhoneType;
use App\Models\Organization;
use App\Models\Shop;
use App\Models\Supplier;
use Database\Factories\AddressFactory;
use Database\Factories\BankFactory;
use Database\Factories\OrganizationFactory;
use Database\Factories\ShopFactory;
use Database\Factories\SupplierFactory;
use Illuminate\Database\Seeder;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        Creating company
        OrganizationFactory::new()->count(10)->create([
            'type' => OrganizationType::Company,
        ])->each(function (Organization $organization) {
            $organization->addresses()->save(AddressFactory::new()->create([
                'label' => 'office',
                'model_id' => $organization->getKey(),
                'model_type' => $organization->getMorphClass(),
            ]));
            //            $organization->setEmail(fake()->unique()->safeEmail());
            $organization->setPhone(fake()->unique()->phoneNumber, PhoneType::Work);
            $organization->setSetting([
                'language' => 'id',
                'timezone' => 'Asia/Jakarta',
                'datetime' => 'Y-m-d H:i:s',
            ]);
            $organization->banks()->saveMany(BankFactory::new()->count(3)->make());
        });

        //        Creating supplier

        SupplierFactory::new()->count(10)->create([
            'type' => OrganizationType::Supplier,
        ])->each(function (Supplier $organization) {
            $organization->addresses()->save(AddressFactory::new()->create([
                'label' => 'office',
                'model_id' => $organization->getKey(),
                'model_type' => $organization->getMorphClass(),
            ]));
            //            $organization->setEmail(fake()->unique()->safeEmail());
            $organization->setPhone(fake()->unique()->phoneNumber, PhoneType::Work);

            $organization->setSetting([
                'language' => 'id',
                'timezone' => 'Asia/Jakarta',
                'datetime' => 'Y-m-d H:i:s',
            ]);
            $organization->banks()->saveMany(BankFactory::new()->count(3)->make());
        });

        //        Creating store
        ShopFactory::new()->count(10)->create([
            'type' => OrganizationType::Store,
        ])->each(function (Shop $organization): void {
            $organization->children()->saveMany(ShopFactory::new()->count(10)->create([
                'type' => OrganizationType::BranchStore,
                'parent_id' => $organization->id,
            ]));
        });
    }
}
