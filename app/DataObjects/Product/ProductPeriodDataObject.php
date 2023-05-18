<?php

namespace App\DataObjects\Product;

use App\DataObjects\BaseDataObject;

class ProductPeriodDataObject extends BaseDataObject
{
    public $id;
    public $product_id;
    public $period_from;
    public $period_to;
}
