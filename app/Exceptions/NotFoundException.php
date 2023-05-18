<?php

namespace App\Exceptions;

use App\Structures\RpcErrors;
use Throwable;

class NotFoundException extends JsonRpcException
{
    use ExceptionSetters;

    /**
     * @param string $message
     * @param int $code
     * @param null $id
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = "Data not Found",
        $code = RpcErrors::NOT_FOUND_CODE,
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
    public function setId(int $id): NotFoundException
    {
        $this->id = $id;

        return $this;
    }
}
