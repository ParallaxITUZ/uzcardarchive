<?php

namespace App\Microservice\Services;

class FileService
{
    private \App\Services\FileService $file_service;
    /**
     * @param \App\Services\FileService $file_service
     */
    public function __construct(\App\Services\FileService $file_service)
    {
        $this->file_service = $file_service;
    }

    public function get()
    {
        $get = ContractPolicyActionData::createFromArray($object->all());
        $result = $this->contract_policy_service->get($get);
        return $result->all();
    }
}
