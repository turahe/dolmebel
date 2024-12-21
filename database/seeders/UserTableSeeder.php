<?php

declare(strict_types=1);
/*
 * This source code is the proprietary and confidential information of
 * Nur Wachid. You may not disclose, copy, distribute,
 *  or use this code without the express written permission of
 * Nur Wachid.
 *
 * Copyright (c) 2023.
 *
 *
 */

namespace Database\Seeders;

use App\Enums\PhoneType;
use App\Models\User;
use Database\Factories\AddressFactory;
use Database\Factories\BankFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create()->each(function (User $user): void {
            //            $user->setEmail(fake()->unique()->safeEmail());
            Auth::login($user);
            $user->setPhone(fake()->unique()->phoneNumber, PhoneType::Mobile);
            $user->addresses()->save(AddressFactory::new()->create([
                'label' => 'home',
                'model_id' => $user->getKey(),
                'model_type' => $user->getMorphClass(),
            ]));
            $user->setSetting([
                'language' => 'id',
                'timezone' => 'Asia/Jakarta',
                'datetime' => 'Y-m-d H:i:s',
            ]);
            $user->banks()->saveMany(BankFactory::new()->count(3)->make());
            $user->assignRole('user');
        });

        $user = UserFactory::new()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole('super-admin');
    }
}
