<?php

namespace App\ActionData\Travel;

use App\ActionData\ActionDataBase;

class ReTravelActionData extends ActionDataBase
{
    public $product_tariff_id;
    public $begin_date;
    public $end_date;
    public $dictionary_purpose_id;
    public $is_family;
    public $multiple;
    public $multiple_type_id;
    public $birthdays;
    public $old_contract_id;

    protected array $rules = [
        "product_tariff_id" => "required",
        "begin_date" => "required|date",
        "end_date" => "required|date",
        "dictionary_purpose_id" => "required",
        "is_family" => "required|boolean",
        "multiple" => "required|boolean",
        "birthdays" => "required",
        "old_contract_id" => "required"
    ];
}
