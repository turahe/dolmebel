<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    protected $model = Bank::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bank = $this->faker->randomElement(\Turahe\Master\Models\Bank::pluck('code')->toArray());

        return [
            'bank_id' => $bank,
            'label' => $this->faker->randomElement(['PRIMARY', 'SECOND']),
            'branch_name' => $this->faker->city,
            'branch_code' => $this->faker->postcode,
            'account_holder' => $this->faker->name,
            'account_number' => $this->faker->creditCardNumber,
            'note' => $this->faker->sentence,
        ];
    }
}
