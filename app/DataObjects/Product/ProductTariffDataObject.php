<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductTariffDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $description;
    public $product;
    public $product_id;
    public $status;
}
