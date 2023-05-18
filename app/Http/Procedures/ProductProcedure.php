<?php

namespace App\Http\Procedures;

use App\ActionData\Product\ProductActionData;
use App\Services\ProductService;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use App\Structures\JsonRpcResponse;
use Illuminate\Support\Facades\Auth;

class ProductProcedure
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function index(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('products_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $items = $this->service->productPaginate(
            request()->get('page', 1),
            request()->get('limit', 10),
            null);
        return JsonRpcResponse::success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('products_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = ProductActionData::createFromRequest($request);
        $item = $this->service->productCreate($action_data);
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
        if (!Auth::user()->hasPermission('products_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->productGet($request);
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
        if (!Auth::user()->hasPermission('products_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $product_action_data = ProductActionData::createFromRequest($request);
        $item = $this->service->productUpdate($product_action_data);
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
        if (!Auth::user()->hasPermission('products_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->productDelete($request);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }
}
