<?php

namespace App\Microservice\Services;

use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionData\Travel\TravelActionData;
use App\Microservice\DataObjects\Calculator\OsagoDataObject;
use App\Microservice\DataObjects\Calculator\TravelDataObject;
use Illuminate\Contracts\Container\BindingResolutionException;

class CalculatorService
{
    private \App\Services\CalculatorService $calculator_service;

    /**
     * @param \App\Services\CalculatorService $calculator_service
     */
    public function __construct(\App\Services\CalculatorService $calculator_service)
    {
        $this->calculator_service = $calculator_service;
    }

    /**
     * @param TravelDataObject $object
     * @return array
     * @throws BindingResolutionException
     */
    public function travel(TravelDataObject $object)
    {
        $travel = TravelActionData::createFromArray($object->all());
        $result = $this->calculator_service->travel($travel);

        return $result->all();
    }

    /**
     * @param OsagoDataObject $object
     * @return array
     * @throws BindingResolutionException
     */
    public function osago(OsagoDataObject $object)
    {
        $travel = OsagoActionData::createFromArray($object->all());
        $result = $this->calculator_service->osago($travel);

        return $result->all();
    }
}
