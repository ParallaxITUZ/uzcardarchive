<?php

namespace App\Requests\Api\Auth;

use App\Requests\Api\RpcBaseRequest;

class IdRequest extends RpcBaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'id' => 'required'
        ];
    }
}
