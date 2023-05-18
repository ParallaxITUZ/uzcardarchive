<?php

namespace App\ActionData\Attempt;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use App\Models\Attempt;
use Faker\Factory;

class AttemptUpdateActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $id;
    public $step;
    public $form_data;

    protected array $rules = [
        "id" => "required",
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
                "id" => Attempt::query()->inRandomOrder()->first()->id,
                "step" => $faker->randomNumber(1, 5),
                "form_data" => "{}",
            ]);
        }
        return $result;
    }
}
