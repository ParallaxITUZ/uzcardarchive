<?php

namespace App\ActionData\PolicyTransfer;

use App\ActionData\ActionDataBase;

class PolicyTransferRangeActionData extends ActionDataBase
{
    public $series;
    public $number_from;
    public $number_to;

    protected array $rules = [
        "series" => "required",
        "number_from" => "required",
        "number_to" => "required"
    ];
}
