<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class PersonActionData extends ActionDataBase
{

    public $passport_series;
    public $passport_number;
    public $birthDate;

    protected array $rules = [
        "passport_series" => ['required'],
        "passport_number" => ['required'],
        "birthDate" => ['required']
    ];
}
