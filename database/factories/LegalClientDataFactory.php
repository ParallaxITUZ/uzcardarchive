<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\DictionaryItem;
use App\Models\LegalClientData;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalClientDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegalClientData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "client_id" => Client::factory(),
            "name" => $this->faker->name,
            "inn" => $this->faker->randomNumber(1000000, 9999999),
            "company" => $this->faker->name,
            "activity_id" => DictionaryItem::factory(),
            "okonx" => $this->faker->randomNumber(0, 999999),
            "director_fish" => $this->faker->name,
            "contact_name" => $this->faker->name,
            "contact_phone" => $this->faker->phoneNumber
        ];
    }
}
