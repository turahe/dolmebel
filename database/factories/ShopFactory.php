<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Turahe\Core\Enums\OrganizationType;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \Faker\Provider\id_ID\Company($this->faker));

        $name = $this->faker->company;

        return [
            'name' => $name,
            'code' => name_alias($name),
            'type' => OrganizationType::Store,
        ];
    }
}
