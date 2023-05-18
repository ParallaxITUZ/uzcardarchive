<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class ReOsagoActionData extends ActionDataBase
{
    public $autotype;
    public $region;
    public $period;
    public $number_drivers;
    public $old_contract_id;
    public $pensioner;

    protected array $rules = [
        "autotype" => "required",
        "region" => "required",
        "period" => "required",
        "number_drivers" => "required",
        "old_contract_id" => "required",
        "pensioner" => "required|bool",
    ];
}
