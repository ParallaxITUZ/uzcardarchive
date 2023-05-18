<?php

namespace App\Http\Controllers\Api;

use App\ActionData\File\FileActionData;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    protected $service;

    /**
     * PermissionProcedure constructor.
     * @param FileService $service
     */
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonRpcResponse
    {
        $action_data = FileActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }
}
