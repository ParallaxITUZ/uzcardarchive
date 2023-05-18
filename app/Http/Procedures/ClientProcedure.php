<?php

namespace App\Http\Procedures;

use App\Filters\BaseFilter;
use App\Filters\ForeignMultipleColumnFilter;
use App\Filters\ForeignTextFilter;
use App\Services\ClientService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ClientProcedure
{
    /**
     * @var ClientService
     */
    protected $service;

    /**
     * ClientProcedure constructor.
     * @param ClientService $service
     */
    public function __construct(ClientService $service)
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
    public function individuals(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('clients_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('phone'), 'phone'),
            ForeignMultipleColumnFilter::get(request('name'), 'client', 'individual', ['first_name', 'last_name', 'middle_name']),
        );

        $items = $this->service->paginateIndividual(
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
    public function legals(): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('clients_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('phone'), 'phone'),
            ForeignTextFilter::get(request('name'), 'client', 'legal', 'name'),
        );

        $items = $this->service->paginateLegal(
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
     * @throws \App\Exceptions\NotFoundException
     */
    public function getIndividual(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('clients_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->getIndividual($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Structures\JsonRpcResponse
     * @throws \App\Exceptions\NotFoundException
     */
    public function getLegal(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('clients_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->getLegal($request));

    }
}
