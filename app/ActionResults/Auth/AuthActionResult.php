<?php

namespace App\ActionResults\Auth;

use App\ActionResults\ActionResultBase;

class AuthActionResult extends ActionResultBase
{
    public $id;
    public $login;
    public $token;
    public $user;
    public $organization_type;
    public $role;
    public $permissions;
}
