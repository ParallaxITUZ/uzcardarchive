<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\PolicyRequest;
use App\Models\PolicyRequestItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyRequestItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PolicyRequestItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'policy_request_id' => PolicyRequest::factory(),
            'policy_id' => Policy::factory(),
            'amount' => $this->faker->randomNumber(0, 1000),
            'approved_amount' => 0,
        ];
    }
}
