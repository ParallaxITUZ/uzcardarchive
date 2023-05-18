<?php

namespace App\ActionData\User;

use App\ActionData\ActionDataBase;

class UserResetPasswordActionData extends ActionDataBase
{
    public $id;
    public $password;
    public $password_confirmation;

    protected array $rules = [
        "password" => ['required', 'confirmed'],
    ];
}
