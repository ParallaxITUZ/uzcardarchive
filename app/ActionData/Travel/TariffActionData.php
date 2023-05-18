<?php

namespace App\ActionData\Travel;

use App\ActionData\ActionDataBase;

class TariffActionData extends ActionDataBase
{
    public $country_ids;

    protected array $rules = [
        "country_ids" => "required|array",
    ];
}
