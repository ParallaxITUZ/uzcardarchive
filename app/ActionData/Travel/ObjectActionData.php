<?php

namespace App\ActionData\Travel;

use App\ActionData\ActionDataBase;

class ObjectActionData extends ActionDataBase
{
    public $first_name;
    public $last_name;
    public $birthdays;
    public $pass_number;
    public $pass_seria;

    protected array $rules = [
        "birthdays" => "required",
        "first_name" => "required",
        "last_name" => "required",
        "pass_number" => "required",
        "pass_seria" => "required",
    ];
}
