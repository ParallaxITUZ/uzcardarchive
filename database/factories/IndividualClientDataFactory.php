<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\IndividualClientData;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndividualClientDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IndividualClientData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "client_id" => Client::factory(),
            "first_name" => $this->faker->firstName,
            "last_name" => $this->faker->lastName,
            "pinfl" => $this->faker->numberBetween(1000000, 9999999) . $this->faker->numberBetween(1000000, 9999999),
            "middle_name" => $this->faker->firstName,
            "passport_seria" => $this->faker->randomLetter.$this->faker->randomLetter,
            "passport_number" => $this->faker->randomNumber(1000000, 9999999),
            "birthday" => $this->faker->date()
        ];
    }
}
