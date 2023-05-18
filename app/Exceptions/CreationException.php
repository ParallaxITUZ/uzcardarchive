<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CreationException extends Exception
{
    public function __construct($message = "", $code = -32025, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
