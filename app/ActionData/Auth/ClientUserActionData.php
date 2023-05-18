<?php

namespace App\ActionData\Auth;

use App\ActionData\ActionDataBase;

class ClientUserActionData extends ActionDataBase
{
    public $phone;
    public $password;

    protected array $rules = [
        'phone' => 'required|string',
        'password' => 'string',
    ];
}
