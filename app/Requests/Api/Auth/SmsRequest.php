<?php

namespace App\Requests\Api\Auth;

use App\Requests\Api\RpcBaseRequest;

class SmsRequest extends RpcBaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|regex:/998[0-9]{9,9}/',
            'code' => 'required'
        ];
    }
}
