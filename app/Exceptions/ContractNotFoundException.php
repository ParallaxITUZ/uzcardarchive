<?php

namespace App\Exceptions;

use Throwable;

class ContractNotFoundException extends JsonRpcException
{
    use ExceptionSetters;

    /**
     * @param string $message
     * @param int $code
     * @param null $id
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = "Contract not found",
        $code = JsonRpcException::PROCEDURE_NOT_FOUND,
        $id = null,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $id, $previous);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): ContractNotFoundException
    {
        $this->id = $id;

        return $this;
    }
}
