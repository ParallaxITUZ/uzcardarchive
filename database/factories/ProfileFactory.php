<?php

namespace Database\Factories;

use App\Models\Dictionary;
use App\Models\Organization;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regions = Dictionary::query()->where('name', '=','regions')->first()->items;
        return [
            'name' => $this->faker->name,
            'region_id' => $regions[array_rand($regions)]->id,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'user_id' => User::factory(),
            'organization_id' => Organization::factory(),
            'position_id' => $this->faker->randomElement()
        ];
    }
}
