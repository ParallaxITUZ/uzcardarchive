<?php

namespace App\Services;

use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionData\OSAGOEpolis\ReOsagoActionData;
use App\ActionData\Travel\ReTravelActionData;
use App\ActionData\Travel\TravelActionData;
use App\DataObjects\ContractAmount\ContractAmountDataObject;
use App\Models\ClientContract;
use App\Models\Currency;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;

class ReCalculatorService
{
    /**
     * @param ReOsagoActionData $action_data
     * @return array
     * @throws BindingResolutionException
     */
    public function osago(ReOsagoActionData $action_data)
    {
        $service = new CalculatorService();
        $calculate_action_data = OsagoActionData::createFromArray([
            "autotype" => $action_data->autotype,
            "region" => $action_data->region,
            "period" => $action_data->period,
            "number_drivers" => $action_data->number_drivers,
            "pensioner" => $action_data->pensioner
        ]);

        $new_price = $service->osago($calculate_action_data)->uzs;
        $old = ClientContract::query()->findOrFail($action_data->old_contract_id);

        $old_price = $old->amount;

        $days = now()->diffInDays($old->begin_date) + 1;
        $amount = floor($old_price / 365) * $days;
        $need = ($old_price - $amount) - $new_price;

        return [
            'new' => new ContractAmountDataObject([
                'uzs' => (int)$new_price,
                'usd' => round($new_price / Currency::getUSDRate(), 2)
            ]),
            'old' => new ContractAmountDataObject([
                'uzs' => (int)$old_price,
                'usd' => round($old_price / Currency::getUSDRate(), 2)
            ]),
            'need' => new ContractAmountDataObject([
                'uzs' => (int)abs($need),
                'usd' => abs(round($need / Currency::getUSDRate(), 2))
            ])
        ];
    }

    /**
     * @param ReTravelActionData $action_data
     * @return array
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function travel(ReTravelActionData $action_data)
    {
        $service = new CalculatorService();
        $calculate_action_data = TravelActionData::createFromArray([

            "product_tariff_id" => $action_data->product_tariff_id,
            "begin_date" => $action_data->begin_date,
            "end_date" => $action_data->end_date,
            "dictionary_purpose_id" => $action_data->dictionary_purpose_id,
            "is_family" => $action_data->is_family,
            "multiple" => $action_data->multiple,
            "birthdays" => $action_data->birthdays
        ]);

        $new_price = $service->travel($calculate_action_data)->uzs;
        $old = ClientContract::query()->findOrFail($action_data->old_contract_id);

        $old_price = $old->amount;
        $days = now()->diffInDays($old->begin_date);
        $amount = floor($old_price / 365) * $days;
        $need = ($old_price - $amount) - $new_price;

        return [
            'new' => new ContractAmountDataObject([
                'uzs' => (int)$new_price,
                'usd' => round($new_price / Currency::getUSDRate(), 2)
            ]),
            'old' => new ContractAmountDataObject([
                'uzs' => (int)$old_price,
                'usd' => round($old_price / Currency::getUSDRate(), 2)
            ]),
            'need' => new ContractAmountDataObject([
                'uzs' => (int)abs($need),
                'usd' => abs(round($need / Currency::getUSDRate(), 2))
            ])
        ];
    }
}
