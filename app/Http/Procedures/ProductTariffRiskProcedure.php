<?php

namespace App\Http\Procedures;

use App\ActionData\Product\ProductTariffRiskActionData;
use App\Services\ProductService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class ProductTariffRiskProcedure
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
        $items = $this->service->productTariffRiskPaginate(request()->get('page', 1), request()->get('limit', 10), null);
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
        $action_data = ProductTariffRiskActionData::createFromRequest($request);
        $item = $this->service->productTariffRiskCreate($action_data);
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
        $item = $this->service->productTariffRiskGet($request);
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
        $product_tariff_action_data = ProductTariffRiskActionData::createFromRequest($request);
        $item =  $this->service->productTariffRiskUpdate($product_tariff_action_data);
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
        $item = $this->service->productTariffRiskDelete($request);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }
}
