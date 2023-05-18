<?php

namespace Database\Factories;

use App\Models\Dictionary;
use App\Models\DictionaryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class DictionaryItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DictionaryItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'display_name' => $this->faker->title,
            'dictionary_id' => Dictionary::factory(),
            'parent_id' => null,
            'order' => null,
            'description' => $this->faker->sentence,
            'value' => null,
        ];
    }
}
