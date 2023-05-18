<?php

namespace App\Microservice\Services;

use App\ActionData\Travel\TariffActionData;
use App\Microservice\DataObjects\Product\ProductTariffDataObject;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class ProgramService
{
    private $program_service;

    /**
     * @param \App\Services\ProgramService $program_service
     */
    public function __construct(\App\Services\ProgramService $program_service)
    {
        $this->program_service = $program_service;
    }

    /**
     * @param ProductTariffDataObject $object
     * @return array
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function travel(ProductTariffDataObject $object): array
    {
        $action_data = TariffActionData::createFromArray([
            'country_ids' => $object->country_ids
        ]);

        return [
            'data' => $this->program_service->travel($action_data)
        ];
    }
}
