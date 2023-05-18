<?php

namespace App\Http\Procedures;

use App\ActionData\Travel\TariffActionData;
use App\Services\ProgramService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class ProgramProcedure
{
    /**
     * @var ProgramService
     */
    protected $service;

    /**
     * ProgramProcedure constructor.
     * @param ProgramService $service
     */
    public function __construct(ProgramService $service)
    {
        $this->service = $service;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Structures\JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function travel(Request $request): JsonRpcResponse {
        $action_data = TariffActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->travel($action_data));
    }
}
