<?php

namespace App\ActionData\PolicyRequest;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;

class PolicyRequestApproveActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $id;
    public $items;

    protected array $rules = [
        "id" => "required",
        "items" => "required|array",
    ];

    /**
     * @param int $amount
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function factory(int $amount = 1): array
    {
        $result = [];
        for ($i = 1; $i <= $amount; $i++){
            $result[] = PolicyRequestApproveActionData::createFromArray([
                "id" => "required",
                "items" => "required|array",
            ]);
        }
        return $result;
    }
}
