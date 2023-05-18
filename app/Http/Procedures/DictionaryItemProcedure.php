<?php

namespace App\Http\Procedures;

use App\ActionData\DictionaryItem\DictionaryItemActionData;
use App\ActionData\DictionaryItem\DictionaryItemIdActionData;
use App\ActionData\DictionaryItem\DictionaryItemUpdateActionData;
use App\Services\DictionaryItemService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DictionaryItemProcedure
{
    /**
     * @var DictionaryItemService
     */
    protected $service;

    /**
     * DictionaryItemProcedure constructor.
     * @param DictionaryItemService $service
     */
    public function __construct(DictionaryItemService $service)
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
        if (!Auth::user()->hasPermission('dictionary_items_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $items = $this->service->paginate(request()->get('page', 1), request()->get('limit', 10));
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
        if (!Auth::user()->hasPermission('dictionary_items_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = DictionaryItemActionData::createFromRequest($request);
        $item = $this->service->create($action_data);
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(Request $request): JsonRpcResponse
    {
        $action_data = DictionaryItemIdActionData::createFromRequest($request);
        $item = $this->service->show($action_data);
        if (isset($item->error)){
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function get(Request $request): JsonRpcResponse
    {
        $action_data = DictionaryItemIdActionData::createFromRequest($request);
        $item = $this->service->get($action_data);
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
        if (!Auth::user()->hasPermission('dictionary_items_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = DictionaryItemUpdateActionData::createFromRequest($request);
        $item =  $this->service->update($action_data);
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermission('dictionary_items_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = DictionaryItemIdActionData::createFromRequest($request);
        $item = $this->service->delete($action_data);
        if ($item->error){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }
}
