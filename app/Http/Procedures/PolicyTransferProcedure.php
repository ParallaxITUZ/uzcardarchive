<?php

namespace App\Http\Procedures;

use App\ActionData\PolicyTransfer\PolicyTransferActionData;
use App\Services\PolicyTransferService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PolicyTransferProcedure
{
    /**
     * @var PolicyTransferService
     */
    protected $service;

    /**
     * PolicyTransferProcedure constructor.
     * @param PolicyTransferService $service
     */
    public function __construct(PolicyTransferService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \App\Structures\JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_transfers_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
//            BaseFilter::get(request('amount'), 'amount'),
//            ForeignLangFilter::get(request('name'), 'warehouse', 'organization' , 'name', request('lang')),
//            BaseFilter::get(request('series'), 'series')
        );

        $items = $this->service->paginate(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );

        return JsonRpcResponse::success($items);
    }

    /**
     * @return \App\Structures\JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function sent(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_transfers_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
//            BaseFilter::get(request('amount'), 'amount'),
//            ForeignLangFilter::get(request('name'), 'warehouse', 'organization' , 'name', request('lang')),
//            BaseFilter::get(request('series'), 'series')
        );

        $items = $this->service->paginateSent(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );

        return JsonRpcResponse::success($items);
    }

    /**
     * @return \App\Structures\JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function received(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_transfers_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
//            BaseFilter::get(request('amount'), 'amount'),
//            ForeignLangFilter::get(request('name'), 'warehouse', 'organization' , 'name', request('lang')),
//            BaseFilter::get(request('series'), 'series')
        );

        $items = $this->service->paginateReceived(
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
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('policy_transfers_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = PolicyTransferActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }
}
