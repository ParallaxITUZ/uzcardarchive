<?php

namespace App\Services;

use App\ActionData\Travel\TariffActionData;
use App\DataObjects\Product\ProductTariffDataObject;
use App\Models\ProductTariff;
use App\Models\ProductTariffBonus;
use Illuminate\Validation\ValidationException;

class ProgramService
{
    /**
     * @param TariffActionData $object
     * @return array
     * @throws ValidationException
     */
    public function travel(TariffActionData $object){
        $object->validate();
        $country_ids = $object->country_ids;
        $items = ProductTariff::query()->whereHas('conditions', function($query) use ($country_ids) {
            $query->has('dictionaryItem')
                ->whereHas('dictionaryItem.items', function($sub_query) use ($country_ids) {
                    $sub_query->where('id', $country_ids);
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
            $result[] = $object;
        }
        return $result;
    }
}
