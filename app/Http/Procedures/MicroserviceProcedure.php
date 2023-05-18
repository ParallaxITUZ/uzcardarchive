<?php

namespace App\Http\Procedures;

use App\Models\Client;
use App\Structures\JsonRpcResponse;
use Illuminate\Http\Request;

class MicroserviceProcedure
{
    /**
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function getByPhone(Request $request): JsonRpcResponse
    {
        $client = Client::query()->where('phone', 'like', '%' . $request->input('phone') . '%')->first();

        $data = optional($client)->data();

        return JsonRpcResponse::success(array_merge([
            'client_id' => optional($client)->getKey(),
            'phone' => optional($client)->phone,
            'first_name' => optional($data)->first_name,
            'last_name' => optional($data)->last_name,
            'middle_name' => optional($data)->middle_name,
            'passport_series' => optional($data)->passport_seria,
            'passport_number' => optional($data)->passport_number,
            'birthdate' => optional($data)->birthday
        ]));
    }

    public function getById(Request $request)
    {
        $client = Client::query()->where('id', $request->client_id)->first();
        $data = $client->data();

        return JsonRpcResponse::success(array_merge([
            'client_id' => $client->id,
            'phone' => $client->phone,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'middle_name' => $data->middle->name,
            'passport_series' => $data->passport_seria,
            'passport_number' => $data->passport_number,
            'birthdate' => $data->birthday
        ]));
    }
}
