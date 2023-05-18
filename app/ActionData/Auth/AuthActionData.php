<?php

namespace App\ActionData\Auth;

use App\ActionData\ActionDataBase;

class AuthActionData extends ActionDataBase
{
    /**
     * @var string
     */
    public $login;
    /**
     * @var string
     */
    public $password;

    protected array $rules = [
        "login" => "required",
        "password" => "required"
    ];
}
