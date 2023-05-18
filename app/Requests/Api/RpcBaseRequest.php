<?php


namespace App\Requests\Api;


use App\Exceptions\JsonRpcException;
use App\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class RpcBaseRequest extends BaseRequest
{
    /**
     * @throws JsonRpcException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new JsonRpcException($validator->errors()->first());
    }
}
