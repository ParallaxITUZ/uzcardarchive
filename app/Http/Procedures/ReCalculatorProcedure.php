<?php

namespace App\Http\Procedures;

use App\ActionData\OSAGOEpolis\ReOsagoActionData;
use App\ActionData\Travel\ReTravelActionData;
use App\Services\ReCalculatorService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReCalculatorProcedure
{
    protected ReCalculatorService $service;

    /**
     * @param ReCalculatorService $service
     */
    public function __construct(ReCalculatorService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws ValidationException
     */
    public function osago(Request $request): JsonRpcResponse
    {
        $action_data = ReOsagoActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->osago($action_data));
    }

    /**
     * @param Request $request
     * @return JsonRpcResponse
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function travel(Request $request): JsonRpcResponse
    {
        $action_data = ReTravelActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->travel($action_data));
    }
}
