<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => Invoice::factory(),
            'amount' => $this->faker->numberBetween(1, 1000).'000',
            'type' => $this->faker->randomElement([Payment::CASH, Payment::CARD]),
            'currency' => $this->faker->randomElement([Payment::UZS, Payment::USD]),
            'comment' => $this->faker->sentence,
            'status' => $this->faker->randomElement([Payment::RETURNED, Payment::PAID]),
        ];
    }
}
