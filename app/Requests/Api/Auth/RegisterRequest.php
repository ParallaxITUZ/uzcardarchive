<?php

namespace App\Requests\Api\Auth;

use App\Requests\Api\RpcBaseRequest;

class RegisterRequest extends RpcBaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|regex:/998[0-9]{9,9}/',
            'password' => 'required|confirmed'
        ];
    }
}
