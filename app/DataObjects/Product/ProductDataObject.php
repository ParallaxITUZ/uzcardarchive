<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $description;
    public $insurance_object;
    public $insurance_form;
    public $insurance_type;
    public $period_type;
    public $currency;
    public $policy;
    public $single_payment;
    public $multi_payment;
    public $tariff_scale_from;
    public $tariff_scale_to;
    public $status;
    public $periods;
    public $insurance_classes;
}
