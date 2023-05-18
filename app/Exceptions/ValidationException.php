<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as BaseValidationException;

class ValidationException extends BaseValidationException
{
    use ExceptionSetters;
}
