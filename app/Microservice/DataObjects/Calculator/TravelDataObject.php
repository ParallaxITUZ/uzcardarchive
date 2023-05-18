<?php

namespace App\Microservice\DataObjects\Calculator;

use App\DataObjects\BaseDataObject;

class TravelDataObject extends BaseDataObject
{
    public $product_tariff_id;
    public $begin_date;
    public $end_date;
    public $dictionary_purpose_id;
    public $is_family;
    public $multiple;
    public $multiple_type_id;
    public $birthdays;
}
