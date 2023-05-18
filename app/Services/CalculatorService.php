<?php

namespace App\Services;

use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionData\Travel\TravelActionData;
use App\DataObjects\ContractAmount\ContractAmountDataObject;
use App\Exceptions\ModelNotFoundException;
use App\Models\ClientContract;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductTariff;
use App\Models\ProductTariffConfiguration;
use Exception;

class CalculatorService
{
    /**
     * @param TravelActionData $action_data
     * @return ContractAmountDataObject
     * @throws Exception
     */
    public function travel(TravelActionData $action_data) {
        $purpose = ProductTariffConfiguration::query()
            ->where('product_tariff_id', $action_data->product_tariff_id)
            ->where('dictionary_item_id', $action_data->dictionary_purpose_id)
            ->firstOrFail();

        $total = 0;

        if($action_data->multiple) {
            $multiple_config = ProductTariffConfiguration::query()
                ->where('product_tariff_id', $action_data->product_tariff_id)
                ->where('dictionary_item_id', $action_data->multiple_type_id)
                ->firstOrFail();

            $amount = $multiple_config->value;
        } else {
            $begin_date = new \DateTime($action_data->begin_date);
            $end_date = new \DateTime($action_data->end_date);
            $interval = $begin_date->diff($end_date);
            $days = intval($interval->format('%a')) + 1;
            $tariff_configurations = ProductTariffConfiguration::query()->select('value')
                ->with('dictionaryItem')
                ->whereHas('dictionaryItem.dictionary', function($query) {
                    $query->where('name', 'days');
                })
                ->where('product_tariff_id', $action_data->product_tariff_id)
                ->whereRaw($days . " between option_from and option_to")
                ->firstOrFail();

            $amount= $tariff_configurations->value * $days;
        }

        if($action_data->is_family) {
            $family_config = ProductTariffConfiguration::query()->select('value')
                ->with('dictionaryItem')
                ->whereHas('dictionaryItem.dictionary', function($query) {
                    $query->where('name', 'family');
                })
                ->where('product_tariff_id', $action_data->product_tariff_id)
                ->whereRaw(count($action_data->birthdays) . " between option_from and option_to")
                ->firstOrFail();

            $total = $amount * $family_config->value;
        } else {
            foreach($action_data->birthdays as $b) {
                $age = floor((time() - strtotime($b)) / 31556926);

                $age_configurations = ProductTariffConfiguration::query()->select('value')
                    ->with('dictionaryItem')
                    ->whereHas('dictionaryItem.dictionary', function($query) {
                        $query->where('name', 'age');
                    })
                    ->where('product_tariff_id', $action_data->product_tariff_id)
                    ->whereRaw($age . " between option_from and option_to")
                    ->first();

                if(!$age_configurations) {
                    $age_coefficient = 1;
                } else {
                    $age_coefficient = $age_configurations->value;
                }

                $total += $amount * $age_coefficient;
            }
        }


        $total *= $purpose->value;

        $uzs = $total * Currency::getUSDRate();
        return new ContractAmountDataObject([
            'uzs' => ((int) $uzs) + 1,
            'usd' =>  $total + 0.01
        ]);
    }

    /**
     * @param OsagoActionData $action_data
     * @return ContractAmountDataObject
     * @throws ModelNotFoundException
     */
    public function osago(OsagoActionData $action_data) {
//        $product_configurations = ProductTariffConfiguration::query()
//            ->where('product_tariff_id', $action_data->product_tariff_id)
//            ->where('dictionary_item_id', $action_data->dictionary_item_id)
//            ->where('status', ProductTariffConfiguration::STATUS_ACTIVE)->firstOrFail();
        $product = Product::query()->findOrFail(ClientContract::PRODUCT_OSAGO);
        $tariff = ProductTariff::query()->where('product_id', $product->id)->firstOrFail();
        $product_configurations = ProductTariffConfiguration::query()
            ->where('product_tariff_id', $tariff->id)
            ->whereIn('dictionary_item_id',  [$action_data->autotype, $action_data->region, $action_data->period, $action_data->number_drivers])
            ->where('status',ProductTariffConfiguration::STATUS_ACTIVE)
            ->get();
        if ($product_configurations->isEmpty()){
            throw new ModelNotFoundException('There is no configurations for this product!');
        }

        $insurance_amount = ProductTariffConfiguration::query()
            ->where('product_tariff_id', $tariff->id)
            ->whereHas('dictionaryItem', function ($query) {
                $query->whereIn('name', ['insurance_amount', 'insurance_amount_percent']);
            })
            ->get();
        if ($insurance_amount->isEmpty()){
            throw new ModelNotFoundException('There is no configurations (insurance amount) for this product!');
        }

        $price = 1;
        foreach ($product_configurations as $p) {
            $price *= $p->value;
        }
        $percent = $insurance_amount->first()->value * ($insurance_amount->last()->value / 100);

        $price = round($price, 2) * $percent;
        $pensioner=ProductTariffConfiguration::query()
            ->where('product_tariff_id', $tariff->id)
            ->whereHas('dictionaryItem', function ($query) {
                $query->whereIn('name', ['is_pensioner']);
            })->first();

        if (!$pensioner){
            throw new ModelNotFoundException('There is no configurations (pensioner) for this product!');
        }

        if ($action_data->pensioner){
            $price= $price * ($pensioner->value / 100);
        }
        return new ContractAmountDataObject([
            'uzs' => (int) $price,
            'usd' =>  round($price/Currency::getUSDRate(), 2) + 0.01
        ]);
    }
}
