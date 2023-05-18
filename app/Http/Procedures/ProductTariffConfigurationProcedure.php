<?php

namespace App\Http\Procedures;

use App\ActionData\Product\ProductTariffConfigurationActionData;
use App\Services\ProductService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class ProductTariffConfigurationProcedure
{
    /**
     * @var ProductService
     */
    protected $service;

    /**
     * DictionaryProcedure constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     */
    public function index(): JsonRpcResponse
    {
        $items = $this->service->productTariffConfigurationPaginate(request()->get('page', 1), request()->get('limit', 10), null);
        if (isset($items->error)){
            return JsonRpcResponse::error($items->error, $items->error_code);
        } else {
            return JsonRpcResponse::success($items);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonRpcResponse
    {
        $action_data = ProductTariffConfigurationActionData::createFromRequest($request);
        $item = $this->service->productTariffConfigurationCreate($action_data);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function get(Request $request): JsonRpcResponse
    {
        $item = $this->service->productTariffConfigurationGet($request);
        if (isset($item->error)){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $product_tariff_configuration_action_data = ProductTariffCOnfigurationActionData::createFromRequest($request);
        $item =  $this->service->productTariffConfigurationUpdate($product_tariff_configuration_action_data);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function destroy(Request $request)
    {
        $item = $this->service->productTariffConfigurationDelete($request);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }
}
