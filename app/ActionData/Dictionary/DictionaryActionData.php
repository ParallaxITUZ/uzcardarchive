<?php

namespace App\ActionData\Dictionary;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use Faker\Factory;

class DictionaryActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $name;
    public $display_name;

    protected array $rules = [
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
            $result[] = DictionaryActionData::createFromArray([
                "name" => $faker->name,
                "display_name" => $faker->name
            ]);
        }
        return $result;
    }
}
