<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PipelineNotFoundException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = __("No pipeline exist. Please add pipeline using [add] method");
    }
}
