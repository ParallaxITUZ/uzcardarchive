<?php

namespace App\Microservice\Facades;

use Illuminate\Support\Facades\Facade;

class RabbitmqDispatcherFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'rabbitmq.dispatcher';
    }
}
