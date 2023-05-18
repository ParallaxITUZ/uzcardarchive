<?php

namespace App\ActionData\Pdf;

use App\ActionData\ActionDataBase;

class TravelActionData extends ActionDataBase
{
    public $contract_id;
    public $display_name;
    public $description;

    protected array $rules = [
        "name" => "required"
    ];
}
