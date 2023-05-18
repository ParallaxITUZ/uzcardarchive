<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class CostActionData extends ActionDataBase
{
    public $discount_id;
    public $discount_sum;
    public $insurance_premium;
    public $sum_insured;
    public $contract_term_conclusion_id;
    public $use_territory_id;
    public $commission;
    public $insurance_premium_paidTo_insurer;
    public $seasonal_insurance_id;

    protected array $rules = [
        "discount_id" => ['required', 'string', 'max:255'],
        "discount_sum" => ['required', 'string', 'max:255'],
        "insurance_premium" => ['required', 'string', 'max:255'],
        "sum_insured" => ['required', 'string', 'max:255'],
        "contract_term_conclusion_id" => ['required', 'string', 'max:255'],
        "use_territory_id" => ['required', 'string', 'max:255'],
        "commission" => ['required', 'string', 'max:255'],
        "insurance_premium_paidTo_insurer" => ['required', 'string', 'max:255'],
        "seasonal_insurance_id" => ['string', 'max:255'],
    ];
}
