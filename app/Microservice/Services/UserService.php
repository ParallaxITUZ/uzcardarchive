<?php

namespace App\Microservice\Services;

use App\Microservice\DataObjects\User\IndividualDataObject;
use App\Microservice\DataObjects\User\UserDataObject;
use App\Models\Client;

class UserService
{
    /**
     * @param UserDataObject $object
     * @return array
     */
    public function updateOrCreate(UserDataObject $object): array
    {
        $client = Client::query()
            ->where('phone', 'ilike', '%' . $object->phone . '%');

        if (! $client->exists()) {
            $client = $client->create([
                'phone' => $object->phone,
                'entity_type_id' => $object->entity_type_id,
                'address' => 'website'
            ]);
        } else {
            $client = $client->first();
        }

        return [
            'client_id' => $client->id
        ];
    }

    /**
     * @param IndividualDataObject $object
     * @return void
     */
    public function updateOrCreateIndividual(IndividualDataObject $object)
    {
        $client = Client::query()->find($object->client_id);

        $client->individual()->updateOrCreate([
            'client_id' => $object->client_id
        ], $object->all());
    }

    /**
     * @param UserDataObject $object
     * @return void
     */
    public function changePhone(UserDataObject $object)
    {
        $client = Client::query()->find($object->client_id);

        $client->update([
            'phone' => $object->phone
        ]);
    }
}
