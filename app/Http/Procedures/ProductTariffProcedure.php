<?php

namespace App\Http\Procedures;

use App\ActionData\Product\ProductTariffActionData;
use App\Services\ProductService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTariffProcedure
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
        $items = $this->service->productTariffPaginate(request()->get('page', 1), request()->get('limit', 10), null);
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
        $action_data = ProductTariffActionData::createFromRequest($request);
        $item = $this->service->productTariffCreate($action_data);
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
        $item = $this->service->productTariffGet($request);
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
        $product_tariff_action_data = ProductTariffActionData::createFromRequest($request);
        $item =  $this->service->productTariffUpdate($product_tariff_action_data);
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
        $item = $this->service->productTariffDelete($request);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }
}
