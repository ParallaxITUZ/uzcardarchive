<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductTariffBonusDataObject  extends BaseDataObject
{
    public $id;
    public $dictionary_item;
    public $dictionary_item_id;
    public $product_condition_tariff;
    public $product_tariff_condition_id;
    public $name;
    public $value;
    public $status;
}
