<?php

namespace App\Http\Procedures;

use App\ActionData\Policy\PolicyActionData;
use App\ActionData\Policy\PolicyUpdateActionData;
use App\Requests\Api\Auth\IdRequest;
use App\Services\PolicyService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyProcedure
{
    /**
     * @var PolicyService
     */
    protected $service;

    /**
     * DictionaryProcedure constructor.
     */
    public function __construct(PolicyService $service)
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
        if (!Auth::user()->hasPermission('policies_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $items = $this->service->paginate(
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
        if (!Auth::user()->hasPermission('policies_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->create(PolicyActionData::createFromRequest($request)));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function get(IdRequest $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policies_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->get($request->get('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('policies_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->update(PolicyUpdateActionData::createFromRequest($request)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function destroy(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('policies_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function deactivate(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('policies_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->deactivate($request->get('id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function activate(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('policies_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->activate($request->get('id')));
    }
}
