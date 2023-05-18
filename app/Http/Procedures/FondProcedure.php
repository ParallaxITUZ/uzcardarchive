<?php

namespace App\Http\Procedures;

use App\ActionData\Client\ClientActionData;
use App\ActionData\Client\IndividualClientActionData;
use App\ActionData\Client\LegalClientActionData;
use App\ActionData\OSAGOEpolis\PersonActionData;
use App\ActionData\OSAGOEpolis\PinflActionData;
use App\ActionData\OSAGOEpolis\ProvidedDiscountActionData;
use App\ActionData\OSAGOEpolis\VehicleActionData;
use App\ActionData\OSAGOEpolis\OrganizationActionData;
use App\ActionData\Travel\ConfigurationActionData;
use App\ActionData\Travel\ObjectActionData;
use App\Services\OsagoFondService;
use App\Structures\JsonRpcResponse;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FondProcedure
{
    public OsagoFondService $service;

    /**
     * @param OsagoFondService $service
     */
    public function __construct(OsagoFondService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonRpcResponse
     * @throws GuzzleException
     */

    public function vehicle(Request $request): JsonRpcResponse
    {
        $actionData = VehicleActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->getVehicleInformation($actionData);

        return JsonRpcResponse::success($data);
    }

    public function person(Request $request): JsonRpcResponse
    {
        $actionData = PersonActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->getPersonInformation($actionData);

        return JsonRpcResponse::success($data);
    }

    public function organization(Request $request): JsonRpcResponse
    {
        $actionData = OrganizationActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->getOrganizationInformation($actionData);

        return JsonRpcResponse::success($data);
    }

    public function pinfl(Request $request): JsonRpcResponse
    {
        $actionData = PinflActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->getPinflInformation($actionData);

        return JsonRpcResponse::success($data);
    }

    public function pensioner(Request $request): JsonRpcResponse
    {
        $actionData = PinflActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->isPensioner($actionData);

        return JsonRpcResponse::success($data);
    }
    public function providedDiscount(Request $request): JsonRpcResponse
    {
        $actionData = ProvidedDiscountActionData::createFromRequest($request);
        $actionData->validate();
        $data = $this->service->providedDiscount($actionData);

        return JsonRpcResponse::success($data);
    }

//    public function createEpolicy(Request $request): JsonRpcResponse
//    {
//        $clientActionData = ClientActionData::createFromRequest($request);
//        $individualClientActionData = IndividualClientActionData::createFromRequest($request);
//        $legalClientActionData = LegalClientActionData::createFromRequest($request);
//        $objectActionData = ObjectActionData::createFromRequest($request);
//        $configurationActionData = ConfigurationActionData::createFromRequest($request);
//        $actionData->validate();
//        $data = $this->service->getSend($actionData);
//
//        return JsonRpcResponse::success($data);
//    }
}
