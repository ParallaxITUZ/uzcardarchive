<?php

namespace App\Requests\Api\Auth;

use App\Requests\Api\RpcBaseRequest;

class LoginRequest extends RpcBaseRequest
{
    public function rules()
    {
        return [
            "login" => "required",
            "password" => "required",
        ];
    }

}
