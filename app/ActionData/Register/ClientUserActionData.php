<?php

namespace App\ActionData\Register;

use App\ActionData\ActionDataBase;

class ClientUserActionData extends ActionDataBase
{
    public $phone;
    public $password;

    protected array $rules = [
        'phone' => 'required|unique:client_users',
        'password' => 'required'
    ];
}
