<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\PolicyRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PolicyRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender_id' => Organization::factory(),
            'receiver_id' => Organization::factory(),
            'requested_user_id' => User::factory(),
            'approved_user_id' => User::factory(),
            'status' => $this->faker->randomElement([
                PolicyRequest::CREATED,
                PolicyRequest::VIEWED,
                PolicyRequest::WORKING,
                PolicyRequest::COMPLETED,
                PolicyRequest::DENIED
            ]),
            'delivery_date' => $this->faker->dateTime(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
