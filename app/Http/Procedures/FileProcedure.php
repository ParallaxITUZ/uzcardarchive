<?php

namespace App\Http\Procedures;

use App\Requests\Api\Auth\IdRequest;
use App\Services\FileService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class FileProcedure
{
    /**
     * @var FileService
     */
    protected FileService $service;

    /**
     * DictionaryProcedure constructor.
     * @param FileService $service
     */
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function get(IdRequest $request): JsonRpcResponse
    {
        $item = $this->service->get($request->get('id'));
        return JsonRpcResponse::success($item);
    }
}
