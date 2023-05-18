<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class ConfigurationActionData  extends ActionDataBase
{
    public $autotype;
    public $region;
    public $period;
    public $number_drivers;
    public $uuid;
    public $owner;
    public $details;
    public $cost;
    public $drivers;
    public $pensioner;

    protected array $rules = [
        "autotype" => "required",
        "region" => "required",
        "period" => "required",
        "pensioner" => "required",
        "number_drivers" => "required",
        "owner" => ["required", "array"],
        "details" => ["required", "array"],
        "cost" => ["required", "array"],
        "drivers" => ["array"],
    ];
}
