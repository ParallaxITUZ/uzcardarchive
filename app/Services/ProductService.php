<?php

namespace App\Services;

use App\ActionData\ActionDataBase;
use App\ActionData\Product\ProductActionData;
use App\ActionData\Product\ProductPeriodActionData;
use App\ActionData\Product\ProductTariffActionData;
use App\ActionData\Product\ProductTariffBonusActionData;
use App\ActionData\Product\ProductTariffConditionActionData;
use App\ActionData\Product\ProductTariffConfigurationActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\BaseDataObject;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Product\ProductDataObject;
use App\DataObjects\Product\ProductTariffDataObject;
use App\DataObjects\Product\ProductTariffBonusDataObject;
use App\DataObjects\Product\ProductTariffConditionDataObject;
use App\DataObjects\Product\ProductTariffConfigurationDataObject;
use App\Exceptions\JsonRpcException;
use App\Microservice\DataObjects\Product\ProductDataObject as RabbitProductDataObject;
use App\Microservice\Services\ProductService as RabbitProductService;
use App\Models\Product;
use App\Models\ProductInsuranceClass;
use App\Models\ProductPeriod;
use App\Models\ProductTariff;
use App\Models\ProductTariffBonus;
use App\Models\ProductTariffCondition;
use App\Models\ProductTariffConfiguration;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Exception;

class ProductService
{
    private RabbitProductService $rabbitProductService;

    /**
     * @param RabbitProductService $rabbitProductService
     */
    public function __construct(RabbitProductService $rabbitProductService)
    {
        $this->rabbitProductService = $rabbitProductService;
    }

    /**
     * @param ActionDataBase $action
     * @return BaseDataObject
     */
    public function calculate(ActionDataBase $action): BaseDataObject
    {
        return $this->product->calculate($action);
    }

    /**
     * @param ProductActionData $product_action_data
     * @return CommonActionResult
     */

    public function productCreate(ProductActionData $product_action_data): CommonActionResult {
        try {
            $product_action_data->validate();
            $product = Product::query()->create([
                'name' => $product_action_data->name,
                'description' => $product_action_data->description,
                'dictionary_insurance_object_id' => $product_action_data->dictionary_insurance_object_id,
                'insurance_form_id' => $product_action_data->insurance_form_id,
                'insurance_type_id' => $product_action_data->insurance_type_id,
                'period_type_id' => $product_action_data->period_type_id,
                'currency_id' => $product_action_data->currency_id,
                'single_payment' => $product_action_data->single_payment,
                'multi_payment' => $product_action_data->multi_payment,
                'tariff_scale_from' => $product_action_data->tariff_scale_from,
                'tariff_scale_to' => $product_action_data->tariff_scale_to,
                'form_id' => $product_action_data->form_id,
                'policy_id' => $product_action_data->policy_id,
                'status' => 1
            ]);

            foreach($product_action_data->insurance_classes as $id) {
                ProductInsuranceClass::query()->create([
                    'product_id' => $product->id,
                    'insurance_class_id' => $id
                ]);
            }

            foreach($product_action_data->periods as $period) {
                $action_data_period = ProductPeriodActionData::createFromArray($period);
                $action_data_period->validate();
                ProductPeriod::query()->create([
                    'product_id' => $product->id,
                    'period_from' => $action_data_period->period_from,
                    'period_to' => $action_data_period->period_to
                ]);
            }
            $object = new RabbitProductDataObject($product->toArray());
            $this->rabbitProductService->create($object);
            return new CommonActionResult($product->id);
        } catch (Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @param ProductActionData $product_action_data
     * @return CommonActionResult
     */
    public function productUpdate(ProductActionData $product_action_data): CommonActionResult {
        try {
            $product_action_data->validate();
            $product = Product::query()->find($product_action_data->id);
            $product->update([
                'name' => $product_action_data->name,
                'description' => $product_action_data->description,
                'dictionary_insurance_object_id' => $product_action_data->dictionary_insurance_object_id,
                'insurance_form_id' => $product_action_data->insurance_form_id,
                'insurance_type_id' => $product_action_data->insurance_type_id,
                'period_type_id' => $product_action_data->period_type_id,
                'currency_id' => $product_action_data->currency_id,
                'single_payment' => $product_action_data->single_payment,
                'multi_payment' => $product_action_data->multi_payment,
                'tariff_scale_from' => $product_action_data->tariff_scale_from,
                'tariff_scale_to' => $product_action_data->tariff_scale_to,
                'form_id' => $product_action_data->form_id,
                'policy_id' => $product_action_data->policy_id,
            ]);

            $classes = ProductInsuranceClass::query()->where('product_id', $product->id)->get();
            foreach ($classes as $class){
                $class->delete();
            }

            foreach($product_action_data->insurance_classes as $id) {
                ProductInsuranceClass::query()->create([
                    'product_id' => $product->id,
                    'insurance_class_id' => $id
                ]);
            }

            foreach($product_action_data->periods as $period) {
                $action_data_period = ProductPeriodActionData::createFromArray($period);
                $action_data_period->validate();
                ProductPeriod::query()->create([
                    'product_id' => $product->id,
                    'period_from' => $action_data_period->period_from,
                    'period_to' => $action_data_period->period_to
                ]);
            }
            $object = new RabbitProductDataObject($product->toArray());
            $this->rabbitProductService->update($object);
            return new CommonActionResult($product->id);
        } catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productDelete(Request $request){
        try {
            $product = Product::query()->find($request->id);
            $product->status = false;
            $object = new RabbitProductDataObject($product->toArray());
            $product->delete();
            $this->rabbitProductService->delete($object);
            return new CommonActionResult($request->id);
        } catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productGet(Request $request){
        if (isset($request->id)){
            if (Product::query()->find($request->id)){
                $item = Product::query()->find($request->id);
                $result = new ProductDataObject($item->toArray());
                $result->insurance_object = $item->insuranceObject;
                $result->insurance_form = $item->insuranceForm;
                $result->insurance_type = $item->insuranceType;
                $result->currency = $item->currency;
                $result->insurance_classes = $item->insuranceClasses;
                $result->period_type = $item->periodType;
                $result->periods = $item->periods;
                $result->policy = $item->policy;
                return $result;
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    /**
     * @throws \Exception
     */
    public function productPaginate($page = 1, $limit = 25, ?iterable $filters = null){
        $product = Product::query()->latest()->paginate($limit);
        $items = $product->getCollection()->transform(function ($item) {
            $result = new ProductDataObject($item->toArray());
            $result->insurance_object = $item->insuranceObject;
            $result->insurance_form = $item->insuranceForm;
            $result->insurance_type = $item->insuranceType;
            $result->currency = $item->currency;
            $result->insurance_classes = $item->insuranceClasses;
            $result->period_type = $item->periodType;
            $result->periods = $item->periods;
            $result->policy = $item->policy;
            return $result;
        });

        return new DataObjectPagination($items, $product->total(), $limit, $page);
    }

    /**
     * @param \App\ActionData\Product\ProductTariffActionData $product_tariff_action_data
     * @return \App\ActionResults\CommonActionResult
     */
    public function productTariffCreate(ProductTariffActionData $product_tariff_action_data): CommonActionResult {
        try {
            $product_tariff_action_data->validate();
            $product_tariff = ProductTariff::query()->create([
                'name' => $product_tariff_action_data->name,
                'description' => $product_tariff_action_data->description,
                'product_id' => $product_tariff_action_data->product_id,
                'status' => $product_tariff_action_data->status
            ]);
            return new CommonActionResult($product_tariff->id);
        }catch (Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @param \App\ActionData\Product\ProductTariffActionData $product_tariff_action_data
     * @return \App\ActionResults\CommonActionResult
     */
    public function productTariffUpdate(ProductTariffActionData $product_tariff_action_data): CommonActionResult {
        try {
            $product_tariff_action_data->validate();
            $product_tariff = ProductTariff::query()->where('id', $product_tariff_action_data->id)->update([
                'name' => $product_tariff_action_data->name,
                'description' => $product_tariff_action_data->description,
                'product_id' => $product_tariff_action_data->product_id,
                'status' => $product_tariff_action_data->status
            ]);
            return new CommonActionResult($product_tariff->id);
        }catch (Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productTariffDelete(Request $request){
        try {
            ProductTariff::query()->find($request->id)->delete();
            return new CommonActionResult($request->id);
        } catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productTariffGet(Request $request){
        if (isset($request->id)){
            if (ProductTariff::query()->find($request->id)){
                $item = ProductTariff::query()->find($request->id);
                $result = new ProductTariffDataObject($item->toArray());
                $result->product = $item->product;
                return $result;
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffPaginate($page = 1, $limit = 25, ?iterable $filters = null){
        try {
            $product_tariff = ProductTariff::query()->latest()->paginate($limit);
            $items = $product_tariff->getCollection()->transform(function ($item) {
                $result = new ProductTariffDataObject($item->toArray());
                $result->product = $item->product;
                return $result;
            });

            return new DataObjectPagination($items, $product_tariff->total(), $limit, $page);
        }catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @param \App\ActionData\Product\ProductTariffConditionActionData $product_tariff_condition_action_data
     * @return \App\ActionResults\CommonActionResult
     */
    public function productTariffConditionCreate(ProductTariffConditionActionData $product_tariff_condition_action_data): CommonActionResult {
        try {
            $product_tariff_condition_action_data->validate();
            $product_tariff_condition = ProductTariffCondition::query()->create([
                'dictionary_id' => $product_tariff_condition_action_data->dictionary_id,
                'product_tariff_id' => $product_tariff_condition_action_data->product_tariff_id
            ]);
            return new CommonActionResult($product_tariff_condition->id);
        }catch (Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @param \App\ActionData\Product\ProductTariffConditionActionData $product_tariff_condition_action_data
     * @return \App\ActionResults\CommonActionResult
     */
    public function productTariffConditionUpdate(ProductTariffConditionActionData $product_tariff_condition_action_data): CommonActionResult {
        try {
            $product_tariff_condition_action_data->validate();
            $product_tariff_condition = ProductTariffCondition::query()->where('id', $product_tariff_condition_action_data->id)->update([
                'dictionary_id' => $product_tariff_condition_action_data->dictionary_id,
                'product_tariff_id' => $product_tariff_condition_action_data->product_tariff_id,
            ]);
            return new CommonActionResult($product_tariff_condition->id);
        }catch (Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productTariffConditionDelete(Request $request){
        try {
            ProductTariffCondition::query()->find($request->id)->delete();
            return new CommonActionResult($request->id);
        } catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    public function productTariffConditionGet(Request $request){
        if (isset($request->id)){
            if (ProductTariffCondition::query()->find($request->id)){
                $item = ProductTariffCondition::query()->find($request->id);
                $result = new ProductTariffConditionDataObject($item->toArray());
                $result->dictionary_item = $item->dictionary_item;
                $result->product_tariff = $item->product_tariff;
                return $result;
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffConditionPaginate($page = 1, $limit = 25, ?iterable $filters = null){
        try {
            $product_tariff_condition = ProductTariffCondition::query()->latest()->paginate($limit);
            $items = $product_tariff_condition->getCollection()->transform(function ($item) {
                $result = new ProductTariffCOnditionDataObject($item->toArray());
                $result->dictionary_item = $item->dictionary_item;
                $result->product_tariff = $item->product_tariff;
                return $result;
            });

            return new DataObjectPagination($items, $product_tariff_condition->total(), $limit, $page);
        }catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), RpcErrors::CRUD_ERROR_CODE);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function productTariffConfigurationCreate(ProductTariffConfigurationActionData $product_tariff_configuration_action_data): CommonActionResult {
        $product_tariff_configuration_action_data->validate();
        $product_tariff_configuration = ProductTariffConfiguration::query()->create([
            'dictionary_item_id' => $product_tariff_configuration_action_data->dictionary_item_id,
            'product_tariff_id' => $product_tariff_configuration_action_data->product_tariff_id,
            'option_from' => $product_tariff_configuration_action_data->option_from,
            'option_to' => $product_tariff_configuration_action_data->option_to,
            'value' => $product_tariff_configuration_action_data->value,
            'status' => 1
        ]);
        return new CommonActionResult($product_tariff_configuration->id);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function productTariffConfigurationUpdate(ProductTariffConfigurationActionData $product_tariff_configuration_action_data, int $id): CommonActionResult {
        $product_tariff_configuration_action_data->validate();
        $product_tariff_configuration = ProductTariffConfiguration::query()->where('id' , $id)->update([
            'dictionary_item_id' => $product_tariff_configuration_action_data->dictionary_item_id,
            'product_tariff_id' => $product_tariff_configuration_action_data->product_tariff_id,
            'option_from' => $product_tariff_configuration_action_data->option_from,
            'option_to' => $product_tariff_configuration_action_data->option_to,
            'value' => $product_tariff_configuration_action_data->value,
            'status' => 1
        ]);
        return new CommonActionResult($product_tariff_configuration->id);
    }

    public function productTariffConfigurationDelete(Request $request){
        if (isset($request->id)){
            if (ProductTariffConfiguration::query()->find($request->id)){
                if (ProductTariffConfiguration::query()->find($request->id)->delete()){
                    return new CommonActionResult($request->id);
                } else {
                    return (new CommonActionResult($request->id))->setError(RpcErrors::CRUD_ERROR_TEXT, RpcErrors::CRUD_ERROR_CODE);
                }
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffConfigurationGet(Request $request){
        if (isset($request->id)){
            if (ProductTariffConfiguration::query()->find($request->id)){
                $item = ProductTariffConfiguration::query()->find($request->id);
                $result = new ProductTariffConfigurationDataObject($item->toArray());
                $result->product_tariff = $item->product_tariff;
                $result->dictionary_item = $item->dictionary_item;
                return $result;
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffConfigurationPaginate($page = 1, $limit = 25, ?iterable $filters = null){
        $product_tariff_configuration = ProductTariffConfiguration::query()->latest()->paginate($limit);
        $items = $product_tariff_configuration->getCollection()->transform(function ($item){
            $result = new ProductTariffConfigurationDataObject($item->toArray());
            $result->product_tariff = $item->product_tariff;
            $result->dictionary_item = $item->dictionary_item;
            return $result;
        });

        return new DataObjectPagination($items, $product_tariff_configuration->total(), $limit, $page);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function productTariffBonusCreate(ProductTariffBonusActionData $product_tariff_bonus_action_data): CommonActionResult {
        $product_tariff_bonus_action_data->validate();
        $product_tariff = ProductTariffBonus::query()->create([
            'dictionary_item_id' => $product_tariff_bonus_action_data->dictionary_item_id,
            'product_condition_tariff_id' => $product_tariff_bonus_action_data->product_condition_tariff_id,
            'name' => $product_tariff_bonus_action_data->name,
            'value' => $product_tariff_bonus_action_data->value,
            'status' => 1
        ]);
        return new CommonActionResult($product_tariff->id);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function productTariffBonusUpdate(ProductTariffBonusActionData $product_tariff_bonus_action_data, int $id): CommonActionResult {
        $product_tariff_bonus_action_data->validate();
        $product_tariff_bonus = ProductTariffBonus::query()->where('id' , $id)->update([
            'dictionary_item_id' => $product_tariff_bonus_action_data->dictionary_item_id,
            'product_condition_tariff_id' => $product_tariff_bonus_action_data->product_condition_tariff_id,
            'name' => $product_tariff_bonus_action_data->name,
            'value' => $product_tariff_bonus_action_data->value,
            'status' => 1
        ]);
        return new CommonActionResult($product_tariff_bonus->id);
    }

    public function productTariffBonusDelete(Request $request){
        if (isset($request->id)){
            if (ProductTariffBonus::query()->find($request->id)){
                if (ProductTariffBonus::query()->find($request->id)->delete()){
                    return new CommonActionResult($request->id);
                } else {
                    return (new CommonActionResult($request->id))->setError(RpcErrors::CRUD_ERROR_TEXT, RpcErrors::CRUD_ERROR_CODE);
                }
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffBonusGet(Request $request){
        if (isset($request->id)){
            if (ProductTariffBonus::query()->find($request->id)){
                $item = ProductTariffBonus::query()->find($request->id);
                $result = new ProductTariffBonusDataObject($item->toArray());
                $result->product_condition_tariff = $item->product_condition_tariff;
                $result->dictionary_item = $item->dictionary_item;
                return $result;
            } else {
                return (new CommonActionResult($request->id))->setError(RpcErrors::NOT_FOUND_TEXT, RpcErrors::NOT_FOUND_CODE);
            }
        } else {
            return (new CommonActionResult($request->id))->setError("Invalid JSON RPC", JsonRpcException::INVALID_JSON_RPC);
        }
    }

    public function productTariffBonusPaginate($page = 1, $limit = 25, ?iterable $filters = null){
        $product_tariff_bonus = ProductTariffBonus::query()->latest()->paginate($limit);
        $items = $product_tariff_bonus->getCollection()->transform(function ($item){
            $result = new ProductTariffBonusDataObject($item->toArray());
            $result->product_condition_tariff = $item->product_condition_tariff;
            $result->dictionary_item = $item->dictionary_item;
            return $result;
        });

        return new DataObjectPagination($items, $product_tariff_bonus->total(), $limit, $page);
    }
}
