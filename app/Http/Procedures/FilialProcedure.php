<?php

namespace App\Http\Procedures;

use App\ActionData\Organization\FilialActionData;
use App\ActionData\Organization\OrganizationActionData;
use App\ActionData\Organization\OrganizationUpdateActionData;
use App\Filters\BaseFilter;
use App\Models\Organization;
use App\Requests\Api\Auth\IdRequest;
use App\Services\OrganizationService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FilialProcedure
{
    /**
     * @var OrganizationService
     */
    protected $service;

    /**
     * FilialProcedure constructor.
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
        if (!Auth::user()->hasPermission('filials_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();
        $filters->push(
            BaseFilter::get(request('name'), 'name'),
        );
        $items = $this->service->paginate(
            Organization::FILIAL,
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
     * @throws \App\Exceptions\BillingException
     * @throws \ErrorException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('filials_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = FilialActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->createFilial($action_data));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function show(IdRequest $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('filials_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->get($request->get('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \App\Exceptions\BillingException
     * @throws \ErrorException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('filials_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = OrganizationUpdateActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->update($action_data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function destroy(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('filials_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }
}
