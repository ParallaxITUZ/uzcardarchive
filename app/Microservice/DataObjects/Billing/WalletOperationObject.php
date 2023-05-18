<?php

namespace App\Microservice\DataObjects\Billing;

use App\DataObjects\BaseDataObject;

class WalletOperationObject extends BaseDataObject
{
    public const TYPE_WITHOUT_PERCENT = 0;

    public const TYPE_WITH_PERCENT = 1;

    public int $organization_id;
    public int $scheme_type = self::TYPE_WITH_PERCENT;
    public int $commission = 0;
    public string $currency = 'UZS';

    protected array $rules = [
        'organization_id' => [
            'nullable',
            'exists:organizations,id'
        ],
        'scheme_type' => [
            'required',
            'in_array:'.self::TYPE_WITH_PERCENT. ','.self::TYPE_WITHOUT_PERCENT
        ],
        'commission' => [
            'required',
            'min:0'
        ],
        'currency' => [
            'required',
            'string',
            'max:3'
        ]
    ];
}
