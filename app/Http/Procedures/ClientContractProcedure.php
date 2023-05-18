<?php

namespace App\Http\Procedures;

use App\ActionData\ClientContract\ClientContractActionData;
use App\ActionData\ReContract\ReContractActionData;
use App\Exceptions\CreationException;
use App\Requests\Api\Auth\IdRequest;
use App\Services\ClientContractService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientContractProcedure
{
    /**
     * @var ClientContractService
     */
    protected $service;

    /**
     * ClientContractProcedure constructor.
     * @param ClientContractService $service
     */
    public function __construct(ClientContractService $service)
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
        if (!Auth::user()->hasPermission('client_contracts_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();
        $filters->push(

        );
        $items = $this->service->paginate(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('client_contracts_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = ClientContractActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }

    /**
     * @param Request $request
     * @return JsonRpcResponse
     * @throws CreationException
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function restore(Request $request): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('re_client_contracts_create')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        $action_data = ReContractActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->reContract($action_data));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function cancel(IdRequest $request): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('client_contracts_paid')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        return JsonRpcResponse::success($this->service->cancelContract($request->id));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function get(IdRequest $request): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('client_contract_read')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        return JsonRpcResponse::success($this->service->get($request));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('client_contract_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $product_action_data = ClientContractActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->update($product_action_data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function destroy(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('client_contract_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }
}
