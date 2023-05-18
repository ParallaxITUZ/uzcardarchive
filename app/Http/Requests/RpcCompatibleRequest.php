<?php

namespace App\Http\Requests;

use App\Exceptions\JsonRpcException;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method fails()
 */
class RpcCompatibleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'jsonrpc' => 'required|in:"2.0"',
            'method' => 'required|string',
            'params' => 'array',
            'id' => 'nullable',
        ];
    }

    /**
     * @return RpcCompatibleRequest
     */
    public function validated(): RpcCompatibleRequest
    {
        $validated = parent::validated();

        foreach ($this->keys() as $key) {
            $this->offsetUnset($key);
        }

        $this->merge(['__id' => $validated['id']])
            ->merge($validated['params'] ?? []);

        return (new self)->merge($validated);
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $validation = new ValidationException($validator);

        throw $validation
            ->setMessage("Invalid Request")
            ->setCode(JsonRpcException::INVALID_JSON_RPC);
    }
}
