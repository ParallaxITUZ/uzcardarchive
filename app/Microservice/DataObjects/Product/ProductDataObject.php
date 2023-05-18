<?php

namespace App\Microservice\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $currency_id;
    public $period;
    public $description;
    public $dictionary_insurance_object_id;
    public $dictionary_insurance_form;
    public $period_type_id;
    public $single_payment;
    public $multi_payment;
    public $anketa_id;
    public $tariff_scale_from;
    public $tariff_scale_to;
    public $status;
    public $policy_id;
    public $params = [];
}
