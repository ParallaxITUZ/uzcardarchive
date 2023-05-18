<?php

namespace App\Exceptions;

use Throwable;

class ModelNotFoundException extends JsonRpcException
{
    use ExceptionSetters;

    /**
     * @param string $message
     * @param int $code
     * @param null $id
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = "Model not found.",
        $code = JsonRpcException::PROCEDURE_NOT_FOUND,
        $id = null,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $id, $previous);
    }
}
