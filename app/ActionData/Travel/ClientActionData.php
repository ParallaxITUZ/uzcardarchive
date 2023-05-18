<?php

namespace App\ActionData\Travel;

use App\ActionData\ActionDataBase;

class ClientActionData extends ActionDataBase
{
    public $first_name;
    public $last_name;
    public $birthday;
    public $pass_number;
    public $pass_seria;
    public $adress;
    public $phone_number;
    public $email;

    protected array $rules = [
        "first_name" => "required",
        "last_name" => "required",
        "birthday" => "required",
        "pass_number" => "required",
        "pass_seria" => "required",
        "adress" => "required",
        "phone_number" => "required",
    ];
}
