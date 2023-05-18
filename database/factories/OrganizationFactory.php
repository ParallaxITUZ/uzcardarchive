<?php

namespace Database\Factories;

use App\Models\Dictionary;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

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
            'parent_id' => Organization::query()->inRandomOrder()->first()->id,
            'organization_type_id' => $this->faker->randomElement([
                Organization::COMPANY,
                Organization::FILIAL,
                Organization::CENTRE,
                Organization::DEPARTMENT,
                Organization::AGENT,
                Organization::WORKER,
                Organization::SUB_AGENT
            ]),
            'company_number' => $this->faker->numberBetween(1000, 9999),
            'filial_number' => $this->faker->numberBetween(1000, 9999),
            'branch_number' => $this->faker->numberBetween(1000, 9999),
            'agent_number' => $this->faker->numberBetween(1000, 9999),
            'sub_agent_number' => $this->faker->numberBetween(1000, 9999),
            'inn' => $this->faker->numberBetween(10000000, 9999999),
            'account' => $this->faker->numberBetween(10000, 99999),
            'address' => $this->faker->address,
            'director_fio' => $this->faker->name,
            'director_phone' => $this->faker->phoneNumber
        ];
    }
}
