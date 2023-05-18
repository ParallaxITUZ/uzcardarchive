<?php

namespace App\Http\Procedures;

use App\ActionData\Warehouse\ImportActionData;
use App\Filters\BaseFilter;
use App\Filters\ForeignLangFilter;
use App\Services\WarehouseService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WarehouseProcedure
{
    /**
     * @var WarehouseService
     */
    protected $service;

    /**
     * DictionaryProcedure constructor.
     * @param WarehouseService $service
     */
    public function __construct(WarehouseService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('warehouse_items_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('amount'), 'amount'),
            ForeignLangFilter::get(request('name'), 'warehouse', 'organization' , 'name', request('lang')),
            BaseFilter::get(request('series'), 'series')
        );

        $items = $this->service->paginate(
            request()->get('page', 1), request()->get('limit', 10), $filters
        );

        return JsonRpcResponse::success($items);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function items(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('warehouse_items_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('amount'), 'amount'),
            ForeignLangFilter::get(request('name'), 'warehouse', 'organization' , 'name', request('lang')),
            BaseFilter::get(request('series'), 'series')
        );

        $items = $this->service->paginateItems(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function import(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('warehouse_items_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->import(ImportActionData::createFromRequest($request)));
    }
}
