<?php

namespace App\ActionData\User;

use App\ActionData\ActionDataBase;

class UserUpdateActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $role;
    public $address;
    public $position_id;
    public $region_id;
    public $pinfl;
    public $phone;

    protected array $rules = [
        "id" => "required",
        "name" => "required",
        "role" => ['required', 'array'],
        "position_id" => ['required'],
        "region_id" => ['required'],
        "pinfl" => ['required'],
        "phone" => ['required'],
    ];
}
