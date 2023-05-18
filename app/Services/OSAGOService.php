<?php


namespace App\Services;


use App\ActionData\ActionDataBase;
use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\ContractAmount\ContractAmountDataObject;
use App\Models\Currency;
use App\Models\ProductTariffConfiguration;
use App\Structures\RpcErrors;

class OSAGOService
{
    /**
     * @param OsagoActionData $action_data
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|int|mixed
     */
    public function calculate(ActionDataBase $action_data) {
        try {
//        $product_configurations = ProductTariffConfiguration::query()
//            ->where('product_tariff_id', $action_data->product_tariff_id)
//            ->where('dictionary_item_id', $action_data->dictionary_item_id)
//            ->where('status', ProductTariffConfiguration::STATUS_ACTIVE)->firstOrFail();

            $product_configurations = ProductTariffConfiguration::query()
                ->whereIn('dictionary_item_id',  [$action_data->autotype, $action_data->region, $action_data->period, $action_data->number_drivers])
                ->where('status',ProductTariffConfiguration::STATUS_ACTIVE)
                ->get();

            $product = $product_configurations->first();

            $insurance_amount = ProductTariffConfiguration::query()
                ->where('product_tariff_id', $product->product_tariff_id)
                ->whereIn('dictionary_item_id', [83, 84])->get();

            $price = 1;

            foreach ($product_configurations as $p) {
                $price *= $p->value;
            }
            $percent = $insurance_amount->first()->value * ($insurance_amount->last()->value / 100);

            $price = round($price, 2) * $percent;

            return new ContractAmountDataObject([
                'uzs' => (int) $price,
                'usd' =>  round($price/Currency::getUSDRate(), 2) + 0.01
            ]);
        } catch (\Exception $e) {
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }
}
