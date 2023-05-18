<?php

namespace App\Exceptions;

trait ExceptionSetters
{
    /**
     * @param string $message
     * @return ValidationException
     */
    public function setMessage(string $message): ValidationException
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code): ValidationException
    {
        $this->code = $code;

        return $this;
    }
}
