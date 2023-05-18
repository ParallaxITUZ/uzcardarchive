<?php

namespace App\Structures;

class RpcProcedures
{
    protected $routes;
    protected $uri;

    public function __construct()
    {
        $this->routes = collect();
    }

    public function addProcedure(string $method, string $procedure)
    {
        $this->routes->put($this->uri.':'.$method, $procedure);
    }

    public function setEndpoint(string $uri)
    {
        $this->uri = $uri;
    }

    public function getProcedures()
    {
        return $this->routes->toArray();
    }

    public function findProcedure(string $method)
    {
        return $this->routes->get($this->uri.':'.$method);
    }
}
