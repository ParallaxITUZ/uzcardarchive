<?php

namespace App\Http\Procedures;

use App\ActionData\PolicyRequest\PolicyRequestActionData;
use App\ActionData\PolicyRequest\PolicyRequestApproveActionData;
use App\ActionData\PolicyRequest\PolicyRequestUpdateActionData;
use App\Filters\ForeignLangFilter;
use App\Models\Dictionary;
use App\Requests\Api\Auth\IdRequest;
use App\Services\PolicyRequestService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PolicyRequestProcedure
{
    /**
     * @var PolicyRequestService
     */
    protected $service;

    /**
     * PermissionProcedure constructor.
     * @param PolicyRequestService $service
     */
    public function __construct(PolicyRequestService $service)
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
    public function sent(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            ForeignLangFilter::get(request('sender'), 'policy_requests', 'sender', 'name', request('lang')),
            ForeignLangFilter::get(request('receiver'), 'policy_requests', 'receiver', 'name', request('lang')),
        );
        $items = $this->service->paginateSent(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function received(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            ForeignLangFilter::get(request('sender'), 'policy_requests', 'sender', 'name', request('lang')),
            ForeignLangFilter::get(request('receiver'), 'policy_requests', 'receiver', 'name', request('lang')),
        );
        $items = $this->service->paginateReceived(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function axo(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            ForeignLangFilter::get(request('sender'), 'policy_requests', 'sender', 'name', request('lang')),
            ForeignLangFilter::get(request('receiver'), 'policy_requests', 'receiver', 'name', request('lang')),
        );
        $items = $this->service->paginateAxo(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = PolicyRequestActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Requests\Api\Auth\IdRequest $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function approveAll(IdRequest $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->approveAll($request->get('id')));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function get(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_requests_read')){
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('policy_requests_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = PolicyRequestUpdateActionData::createFromRequest($request);
        $item = $this->service->update($action_data);
        return JsonRpcResponse::success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function approve(Request $request)
    {
        if (!Auth::user()->hasPermission('policy_requests_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = PolicyRequestApproveActionData::createFromRequest($request);
        $item = $this->service->approve($action_data);
        return JsonRpcResponse::success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function destroy(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('policy_requests_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->delete($request->get('id'));
        return JsonRpcResponse::success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function reject(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('policy_requests_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->reject($request->get('id'));
        return JsonRpcResponse::success($item);
    }
}
