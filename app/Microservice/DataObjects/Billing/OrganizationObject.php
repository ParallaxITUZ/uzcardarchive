<?php

namespace App\Microservice\DataObjects\Billing;

use App\DataObjects\BaseDataObject;

class OrganizationObject extends BaseDataObject
{
    public int $organization_id;

    public string $currency;

    protected array $rules = [
        'organization_id' => [
            'required',
            'int',
            'exists:organizations,id',
        ],
        'currency'  =>  [
            'required',
            'string',
            'max:3'
        ]
    ];
}
