<?php

namespace App\ActionData\PolicyRequest;

use App\ActionData\ActionDataBase;

class PolicyRequestItemApproveActionData extends ActionDataBase
{
    public $id;
    public $amount;

    protected array $rules = [
        "id" => "required",
        "amount" => "required|integer|min:1",
    ];
}
