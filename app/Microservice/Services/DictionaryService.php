<?php

namespace App\Microservice\Services;

use App\Microservice\DataObjects\Dictionary\DictionaryDataObject;

class DictionaryService
{
    private $service;

    /**
     * @param \App\Services\DictionaryService $program_service
     */
    public function __construct(\App\Services\DictionaryService $program_service)
    {
        $this->service = $program_service;
    }

    /**
     * @param DictionaryDataObject $object
     * @return array
     */
    public function showByName(DictionaryDataObject $object)
    {
        return $this->service->showByName($object->name)->all();
    }
}
