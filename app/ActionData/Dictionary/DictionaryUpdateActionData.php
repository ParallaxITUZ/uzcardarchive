<?php

namespace App\ActionData\Dictionary;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use App\Models\Dictionary;
use Faker\Factory;

class DictionaryUpdateActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $id;
    public $name;
    public $display_name;

    protected array $rules = [
        "id" => "required",
        "name" => "required",
        "display_name" => "required"
    ];

    /**
     * @param int $amount
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function factory(int $amount = 1): array
    {
        $faker = Factory::create();
        $result = [];
        for ($i = 1; $i <= $amount; $i++){
            $result[] = DictionaryUpdateActionData::createFromArray([
                "id" => Dictionary::query()->inRandomOrder()->first()->id,
                "name" => $faker->name,
                "display_name" => $faker->name
            ]);
        }
        return $result;
    }
}
