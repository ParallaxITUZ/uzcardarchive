<?php


namespace App\Services;

use App\ActionData\ActionDataBase;
use App\ActionData\Travel\TariffActionData;
use App\ActionData\Travel\TravelActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\ContractAmount\ContractAmountDataObject;
use App\DataObjects\Product\ProductTariffDataObject;
use App\Models\Currency;
use App\Models\ProductTariff;
use App\Models\ProductTariffBonus;
use App\Models\ProductTariffConfiguration;
use App\Structures\RpcErrors;

class TravelService
{

    /**
     * @param TariffActionData $action_data
     * @return CommonActionResult|array
     */
    public function getPrograms(TariffActionData $action_data){
        try {
            $action_data->validate();
            $country_ids = $action_data->country_ids;
            $items = ProductTariff::query()->whereHas('conditions', function($query) use ($country_ids) {
                $query->has('dictionaryItem')
                    ->whereHas('dictionaryItem.items', function($subquery) use ($country_ids) {
                        $subquery->where('id', $country_ids);
                    });
            })->get();

            $result = [];
            foreach ($items as $item){
                $object = new ProductTariffDataObject($item->toArray());
                $object->bonuses = ProductTariffBonus::query()
                    ->has('productTariffCondition')
                    ->whereHas('productTariffCondition', function($query) use ($item) {
                        $query->where('product_tariff_id', $item->id);
                    })
                    ->has('productTariffCondition.dictionaryItem')
                    ->whereHas('productTariffCondition.dictionaryItem.items', function($query) use ($country_ids) {
                        $query->where('id', $country_ids);
                    })
                    ->get();
//                $object->product = $item->product;
//                $object->conditions = $item->conditions;
                $result[] = $object;
            }
            return $result;
        } catch (\Exception $e) {
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @param TravelActionData $action_data
     * @return CommonActionResult|ContractAmountDataObject
     */
    public function calculate(ActionDataBase $action_data) {
        try {
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
                        $age_coeff = 1;
                    } else {
                        $age_coeff = $age_configurations->value;
                    }

                    $total += $amount * $age_coeff;
                }
            }

            $total *= $purpose->value;

            $uzs = $total * Currency::getUSDRate();
            return new ContractAmountDataObject([
                'uzs' => ((int) $uzs) + 1,
                'usd' =>  $total + 0.01
            ]);
        } catch (\Exception $e) {
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }
}
