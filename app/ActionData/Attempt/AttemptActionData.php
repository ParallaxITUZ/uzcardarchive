<?php

namespace App\ActionData\Attempt;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use Faker\Factory;

class AttemptActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $step;
    public $form_data;

    protected array $rules = [
        "step" => "required",
        "form_data" => "required",
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
            $result[] = AttemptActionData::createFromArray([
                "step" => $faker->randomNumber(1, 5),
                "form_data" => "{}",
            ]);
        }
        return $result;
    }
}
