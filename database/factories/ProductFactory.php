<?php

namespace Database\Factories;

use App\Models\DictionaryItem;
use App\Models\Policy;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'dictionary_insurance_object_id' => DictionaryItem::factory(),
            'insurance_form_id',
            'insurance_type_id',
            'period_type_id',
            'currency_id',
            'single_payment',
            'multi_payment',
            'tariff_scale_from',
            'tariff_scale_to',
            'form_id' => $this->faker->randomNumber(0, 22),
            'policy_id' => Policy::factory(),
        ];
    }
}
