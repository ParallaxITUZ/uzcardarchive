<?php

namespace App\ActionData\Travel;

use App\ActionData\ActionDataBase;

class ConfigurationActionData extends ActionDataBase
{
    public $dictionary_purpose_id;
    public $product_tariff_id;
    public $multiple;
    public $is_family;
    public $multiple_type_id;
    public $days;
    public $countries;
    public $begin_date;
    public $end_date;

    protected array $rules = [
        "dictionary_purpose_id" => "required",
        "is_family" => "required|boolean",
        "days" => "required",
        "countries" => "required",
        "begin_date" => "required|date",
        "end_date" => "required|date",
    ];
}
