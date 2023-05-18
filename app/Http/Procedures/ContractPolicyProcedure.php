<?php

namespace App\Http\Procedures;

use App\Filters\BaseFilter;
use App\Filters\BaseLangFilter;
use App\Services\ContractPolicyService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ContractPolicyProcedure
{
    /**
     * @var ContractPolicyService
     */
    protected $service;

    /**
     * ContractPolicyProcedure constructor.
     */
    public function __construct(ContractPolicyService $service)
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
//        if (!Auth::user()->hasPermission('contract_policies_read')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('name'), 'name'),
            BaseLangFilter::get(request('display_name'), 'display_name'),
        );

        $items = $this->service->paginate(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }
}
