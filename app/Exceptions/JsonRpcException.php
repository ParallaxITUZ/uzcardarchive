<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class JsonRpcException extends Exception
{
    use ExceptionSetters;

    const INVALID_JSON_RPC = -32600;
    const PROCEDURE_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;

    const UNAUTHENTICATED = -32001;

    public $id;

    public function __construct($message = "", $code = 0, $id = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }
}
