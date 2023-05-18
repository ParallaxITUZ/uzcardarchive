<?php


namespace App\Http\Procedures;

use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionData\Travel\TravelActionData;
use App\Services\CalculatorService;
use App\Services\OSAGOService;
use App\Services\TravelService;
use App\Structures\JsonRpcResponse;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CalculatorProcedure
{
    /**
     * @var TravelService
     * @var OSAGOService
     */
    protected CalculatorService $service;

    /**
     * CalculatorProcedure constructor.
     * @param CalculatorService $service
     */
    public function __construct(CalculatorService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws BindingResolutionException
     * @throws ValidationException
     * @throws Exception
     */
    public function travel(Request $request): JsonRpcResponse
    {
        $action_data = TravelActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->travel($action_data));
    }

    /**
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function osago(Request $request): JsonRpcResponse
    {
        $action_data = OsagoActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->osago($action_data));
    }
}
