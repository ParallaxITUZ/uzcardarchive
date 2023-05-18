<?php

namespace App\ActionData\ContractPolicy;

use App\ActionData\ActionDataBase;

class ContractPolicyActionData extends ActionDataBase
{
    public $contract_id;

    protected array $rules = [
        "contract_id" => "required"
    ];
}
