<?php

namespace Database\Factories;

use App\Models\AgentData;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_id' => Organization::factory(),
            'agent_type_id' => $this->faker->randomElement([
                Organization::AGENT_TYPE_FIZ,
                Organization::AGENT_TYPE_YUR,
                Organization::AGENT_TYPE_COMPANY,
                Organization::AGENT_TYPE_SUB
            ]),
            'pinfl' => $this->faker->numberBetween(1000000, 9999999) . $this->faker->numberBetween(1000000, 9999999),
        ];
    }
}
