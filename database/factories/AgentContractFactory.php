<?php

namespace Database\Factories;

use App\Models\AgentContract;
use App\Models\File;
use App\Models\Organization;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AgentContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentContract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'date_from' => $this->faker->dateTimeBetween('-10 years', '-5 years'),
            'date_to' => $this->faker->dateTimeBetween('-5 years', '+5 years'),
            'number' => $this->faker->numberBetween(0, 10000),
            'commission' => rand(0, 25),
            'signer' => $this->faker->name,
            'file_id' => File::factory(),
            'status' => $this->faker->randomElement([
                AgentContract::STATUS_ACTIVE,
                AgentContract::STATUS_PASSIVE
            ]),
        ];
    }

    public function passive(){
        return $this->state(function (array $attributes){
            return [
                'status' => AgentContract::STATUS_PASSIVE
            ];
        });
    }

    public function active(){
        return $this->state(function (array $attributes){
            return [
                'status' => AgentContract::STATUS_ACTIVE
            ];
        });
    }
}
