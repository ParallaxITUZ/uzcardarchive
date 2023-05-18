<?php

namespace App\Microservice\DataObjects\Billing;

use App\DataObjects\BaseDataObject;

class WalletObject extends BaseDataObject
{
    public const CASH_PAYMENT_TYPE = 1;
    public const BANK_CARD_PAYMENT_TYPE = 2;
    public const UZ_CARD_PAYMENT_TYPE = 3;

    /**
     * @var array|WalletOperationObject
     */
    public $from = [];

    /**
     * @var array|WalletOperationObject
     */
    public $to = [];

    public float $balance = 0;

    public ?int $invoice_id = null;

    public int $user_id;

    public int $payment_type;

    public float $amount = 0;

    public array $filter = [];

    public $dates_data;

    public $meta;

    public function __construct(array $parameters = [])
    {
        foreach ($parameters as $key => $parameter) {
            if ('from' == $key) {
                $parameters['from'] = new WalletOperationObject($parameter);
            }

            if ('to' == $key) {
                $parameters['to'] = new WalletOperationObject($parameter);
            }
        }

        parent::__construct($parameters);
    }
}
