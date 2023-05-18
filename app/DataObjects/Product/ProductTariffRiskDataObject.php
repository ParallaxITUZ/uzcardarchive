<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductTariffRiskDataObject extends BaseDataObject
{
    public $id;
    public $product_tariff_id;
    public $name;
    public $amount;
}
