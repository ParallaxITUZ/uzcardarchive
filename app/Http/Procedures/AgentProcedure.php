<?php

namespace App\Http\Procedures;

use App\ActionData\Organization\AgentActionData;
use App\ActionData\Organization\AgentUpdateActionData;
use App\Filters\BaseFilter;
use App\Requests\Api\Auth\IdRequest;
use App\Services\OrganizationService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AgentProcedure
{
    /**
     * @var OrganizationService
     */
    protected $service;

    /**
     * AgentProcedure constructor.
     * @param OrganizationService $service
     */
    public function __construct(OrganizationService $service)
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
        if (!Auth::user()->hasPermission('agents_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();
        $filters->push(
            BaseFilter::get(request('name'), 'name'),
        );
        $items = $this->service->paginateAgent(
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
     * @throws Exception
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('agents_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = AgentActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->createAgent($action_data));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function show(IdRequest $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('agents_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->getAgent($request->get('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('agents_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = AgentUpdateActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->updateAgent($action_data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermission('agents_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }
}
