<?php

namespace Database\Factories;

use App\Models\ClientContract;
use App\Models\ContractPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractPolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractPolicy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => ClientContract::factory(),
            'series' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'number' => $this->faker->numberBetween(0, 999999)
        ];
    }
}
