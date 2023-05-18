<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductTariffConditionDataObject extends BaseDataObject
{
    public $id;
    public $dictionary_item;
    public $dictionary_item_id;
    public $product_tariff;
    public $product_tariff_id;
}
