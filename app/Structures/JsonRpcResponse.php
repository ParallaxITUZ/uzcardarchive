<?php

namespace App\Structures;


use Illuminate\Contracts\Support\Jsonable;

class JsonRpcResponse implements Jsonable
{
    const JSON_RPC_VERSION = '2.0';

    public $jsonRpc = self::JSON_RPC_VERSION;
    /**
     * @var boolean
     */
    public $success;
    /**
     * @var ?array
     */
    public $error;
    /**
     * @var ?array
     */
    public $data;
    /**
     * @var int|null
     */
    public $id;

    /**
     * @param $success
     * @param $error
     * @param null $data
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function __construct($success, $error, $data = null)
    {
        $this->success = $success;
        $this->error = $error;
        $this->data = $data;
        $this->id = request()->get("__id");
    }

    /**
     * @param null $data
     * @return static
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function success($data = null): self
    {
        return new JsonRpcResponse(true, null, $data);
    }

    /**
     * @param $message
     * @param $code
     * @param null $exception
     * @param null $original_message
     * @param null $additional_array
     * @return static
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function error($message, $code, $exception = null, $original_message = null, $additional_array = null): self
    {
        return new JsonRpcResponse(null, [
            "code" => $code,
            "message" => $message,
            "exception" => $exception,
            "original_message" => $original_message,
            "additional_array" => $additional_array
        ], null);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this, $options);
    }
}
