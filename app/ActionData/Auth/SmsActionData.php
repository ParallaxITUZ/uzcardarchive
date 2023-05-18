<?php

namespace App\ActionData\Auth;

use App\ActionData\ActionDataBase;

class SmsActionData extends ActionDataBase
{
    public $code;
    public $phone;

    protected array $rules = [
        'code' => 'required',
        'phone' => 'required'
    ];
}
