<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductInsuranceClassActionData extends ActionDataBase
{
    public $product_id;
    public $insurance_class_id;

    protected array $rules = [
        "product_id" => "required",
        "insurance_class_id" => "required",
    ];
}
