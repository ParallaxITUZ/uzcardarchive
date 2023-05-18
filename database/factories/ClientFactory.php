<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Dictionary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $entity_types = Dictionary::query()->where('name', '=', 'entity_types')->first()->items;
        return [
            'entity_type_id' => $this->faker->randomElement([

            ]),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'registered_user_id' => User::factory(),
        ];
    }
}
