<?php

namespace App\ActionData\User;

use App\ActionData\ActionDataBase;

class UserActionData extends ActionDataBase
{
    public $name;
    public $login;
    public $password;
    public $role;
    public $organization_id;
    public $address;
    public $position_id;
    public $region_id;
    public $pinfl;
    public $phone;

    protected array $rules = [
        "name" => "required",
        "login" => ['required', 'string', 'max:255', 'unique:users'],
        "role" => ['required', 'array'],
        "organization_id" => ['required'],
        "position_id" => ['required'],
        "region_id" => ['required'],
        "pinfl" => ['required'],
        "phone" => ['required'],
        "password" => ['required'],
    ];
}
