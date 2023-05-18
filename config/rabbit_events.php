<?php

use App\Microservice\DataObjects\Calculator\TravelDataObject;
use App\Microservice\DataObjects\Contract\ContractDataObject;
use App\Microservice\DataObjects\Dictionary\DictionaryDataObject;
use App\Microservice\DataObjects\Product\ProductDataObject;
use App\Microservice\DataObjects\Product\ProductTariffDataObject;
use App\Microservice\DataObjects\User\IndividualDataObject;
use App\Microservice\DataObjects\User\UserDataObject;
use App\Microservice\Services\CalculatorService;
use App\Microservice\Services\ClientContractService;
use App\Microservice\Services\DictionaryService;
use App\Microservice\Services\ProductService;
use App\Microservice\Services\ProgramService;
use App\Microservice\Services\UserService;

return [
    'user' => [
        'updateOrCreate' => [
            'phone' => [
                'class' => UserService::class,
                'method' => 'updateOrCreate',
                'dto' => UserDataObject::class
            ]
        ]
    ],
    'getAllProducts' => [
        'class' => ProductService::class,
        'method' => 'getAll',
        'dto' => ProductDataObject::class
    ],
    'addProgram' => [
        'class' => ProgramService::class,
        'method' => 'travel',
        'dto' => ProductTariffDataObject::class
    ],
    'getDictionary' => [
        'class' => DictionaryService::class,
        'method' => 'showByName',
        'dto' => DictionaryDataObject::class
    ],
    'travelCalculator' => [
        'class' => CalculatorService::class,
        'method' => 'travel',
        'dto' => TravelDataObject::class
    ],
    'storeContract' => [
        'class' => ClientContractService::class,
        'method' => 'create',
        'dto' => ContractDataObject::class
    ],
    'individual' => [
        'createOrUpdate' => [
            'class' => UserService::class,
            'method' => 'updateOrCreateIndividual',
            'dto' => IndividualDataObject::class
        ]
    ],
    'changePhone' => [
        'class' => UserService::class,
        'method' => 'changePhone',
        'dto' => UserDataObject::class
    ]
];
