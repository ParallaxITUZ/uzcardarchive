<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $description;
    public $dictionary_insurance_object_id;
    public $insurance_form_id;
    public $insurance_type_id;
    public $period_type_id;
    public $currency_id;
    public $single_payment;
    public $multi_payment;
    public $tariff_scale_from;
    public $tariff_scale_to;
    public $form_id;
    public $periods;
    public $insurance_classes;
    public $policy_id;

    protected array $rules = [
        "id" => "sometimes|exists:products,id",
        "name" => "required",
        "description" => "required",
        "dictionary_insurance_object_id" => "required",
        "insurance_form_id" => "required",
        "insurance_type_id" => "required",
        "period_type_id" => "required",
        "currency_id" => "required",
        "single_payment" => "required",
        "multi_payment" => "required",
        "tariff_scale_from" => "required",
        "tariff_scale_to" => "required",
        "form_id" => "required",
        "periods" => "required|array",
        "insurance_classes" => "required|array",
        'policy_id' => "required|int|exists:policies,id",
    ];
}
