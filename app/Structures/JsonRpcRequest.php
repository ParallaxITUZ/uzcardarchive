<?php

namespace App\Structures;

class JsonRpcRequest
{
    protected $id;
    protected $method;
    protected $params;

    public function __construct(string $id, string $method, array $params)
    {
        $this->id = $id;
        $this->method = $method;
        $this->params = $params;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "jsonrpc" => "2.0",
            "method" => $this->method,
            "params" => $this->params
        ];
    }
}
