<?php

namespace App\Services;

use App\ActionData\Client\ClientActionData;
use App\ActionData\Client\IndividualClientActionData;
use App\ActionData\Client\LegalClientActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\Client\IndividualClientDataObject;
use App\DataObjects\Client\LegalClientDataObject;
use App\DataObjects\DataObjectPagination;
use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\Models\DictionaryItem;
use App\Models\IndividualClientData;
use App\Models\LegalClientData;
use App\Services\Concerns\Paginator;
use Exception;
use Illuminate\Support\Facades\DB;

class ClientService
{
    use Paginator;
    /**
     * @param \App\ActionData\Client\ClientActionData $action_data
     * @return \App\ActionResults\CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws Exception
     */
    public function create(ClientActionData $action_data){
        try {
            $action_data->validate();
            DB::beginTransaction();

            $entity_type = DictionaryItem::query()->findOrFail($action_data->entity_type_id);
            if ($entity_type->dictionary->name != 'entity_types'){
                throw new NotFoundException('There no entity type with id '.$action_data->entity_type_id);
            }
            if ($entity_type->name == "individual" && isset($action_data->individual) && $action_data->individual){
                $client_individual_action_data = IndividualClientActionData::createFromArray($action_data->individual);
                $client_individual_action_data->validate();

                $client = $this->getClient($action_data, $client_individual_action_data->pinfl);
                $query = IndividualClientData::query();

                if (! $query->where('pinfl', $client_individual_action_data->pinfl)->exists()) {
                    IndividualClientData::query()->create([
                        "client_id" => $client->id,
                        "pinfl" => $client_individual_action_data->pinfl,
                        "first_name" => $client_individual_action_data->first_name,
                        "last_name" => $client_individual_action_data->last_name,
                        "middle_name" => $client_individual_action_data->middle_name,
                        "passport_seria" => $client_individual_action_data->passport_seria,
                        "passport_number" => $client_individual_action_data->passport_number,
                        "birthday" => $client_individual_action_data->birthday,
                        "gender" => $client_individual_action_data->gender,
                        "region_id" => $client_individual_action_data->region_id,
                        "district_id" => $client_individual_action_data->district_id,
                        //pass_issue_date ...
                    ]);
                }
            } elseif ($entity_type->name == "legal" && isset($action_data->legal) && $action_data->legal) {
                $client_legal_action_data = LegalClientActionData::createFromArray($action_data->legal);
                $client_legal_action_data->validate();

                $client = $this->getClient($action_data, null, $client_legal_action_data->inn);
                $query = LegalClientData::query();

                if (! $query->where('inn', $client_legal_action_data->inn)->exists()) {
                    LegalClientData::query()->create([
                        "client_id" => $client->id,
                        "name" => $client_legal_action_data->name,
                        "inn" => $client_legal_action_data->inn,
                        "okonx" => $client_legal_action_data->okonx,
                        "company" => $client_legal_action_data->company,
                        "director_fish" => $client_legal_action_data->director_fish,
                        "contact_name" => $client_legal_action_data->contact_name,
                        "contact_phone" => $client_legal_action_data->contact_phone,
                    ]);
                }
            } else {
                throw new Exception('legal/individual required');
            }
            DB::commit();
            return new CommonActionResult($client->id);
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $pinfl
     * @param int $inn
     * @return bool
     * @throws \Exception
     */
    public function checkClient(int $pinfl, int $inn){
        if ($pinfl == null && $inn == null){
            throw new Exception('Inn/Pinfl required');
        }
        if ($pinfl) {
            $client = Client::with(['individual' => function ($query) use ($pinfl) {
                $query->where('pinfl', $pinfl);
            }])->firstOrFail();
        } elseif ($inn) {
            $client = Client::with(['legal' => function ($query) use ($inn) {
                $query->where('inn', $inn);
            }])->firstOrFail();
        } else {
            $client = null;
        }
        return (bool)$client;
    }

    /**
     * @throws Exception
     */
    public function getClient(ClientActionData $action_data, $pinfl = null, $inn = null)
    {
        if ($pinfl == null && $inn == null){
            throw new Exception('Inn/Pinfl required');
        }
        if ($pinfl) {
            $client = Client::with(['individual' => function ($query) use ($pinfl) {
                $query->where('pinfl', $pinfl);
            }])->first();
        } elseif ($inn) {
            $client = Client::with(['legal' => function ($query) use ($inn) {
                $query->where('inn', $inn);
            }])->first();
        } else {
            $client = null;
        }

        if (!$client) {
            $client = Client::query()->create([
                "entity_type_id" => $action_data->entity_type_id,
                "address" => $action_data->address,
                "phone" => ltrim($action_data->phone, '+'),
                "registered_user_id" => $action_data->registered_user_id,
            ]);
        }
        return $client;
    }

    /**
     * @throws Exception
     */
    public function get(int $id)
    {
        $client = Client::query()->findOrFail($id);
        if ($client->legal){
            $result = new LegalClientDataObject($client->toArray());
            $result->name = $client->legal->name;
            $result->inn = $client->legal->inn;
            $result->company = $client->legal->company;
            $result->activity = $client->legal->activity;
            $result->okonx = $client->legal->okonx;
            $result->director_fish = $client->legal->director_fish;
            $result->contact_name = $client->legal->contact_name;
            $result->contact_phone = $client->legal->contact_phone;
            return $result;
        } elseif ($client->individual){
            $result = new IndividualClientDataObject($client->toArray());
            $result->first_name = $client->individual->first_name;
            $result->last_name = $client->individual->last_name;
            $result->middle_name = $client->individual->middle_name;
            $result->passport_seria = $client->individual->passport_seria;
            $result->passport_number = $client->individual->passport_number;
            return $result;
        } else {
            $client->delete();
            throw new NotFoundException("There is no client with $id id");
        }
    }

    /**
     * @param int $id
     * @return \App\DataObjects\Client\IndividualClientDataObject
     * @throws \App\Exceptions\NotFoundException
     */
    public function getIndividual(int $id){
        $item = Client::query()->findOrFail($id);
        $result = new IndividualClientDataObject($item->toArray());
        if (!$item->individual){
            throw new NotFoundException('Individual client not found!');
        }
        $result->first_name = $item->individual->first_name;
        $result->last_name = $item->individual->last_name;
        $result->middle_name = $item->individual->middle_name;
        $result->passport_seria = $item->individual->passport_seria;
        $result->passport_number = $item->individual->passport_number;
        return $result;
    }

    /**
     * @param int $id
     * @return \App\DataObjects\Client\LegalClientDataObject
     * @throws \App\Exceptions\NotFoundException
     */
    public function getLegal(int $id){
        $item = Client::query()->findOrFail($id);
        if (!$item->legal){
            throw new NotFoundException('Legal client not found!');
        }
        $result = new LegalClientDataObject($item->toArray());
        $result->name = $item->legal->name;
        $result->inn = $item->legal->inn;
        $result->company = $item->legal->company;
        $result->activity = $item->legal->activity;
        $result->okonx = $item->legal->okonx;
        $result->director_fish = $item->legal->director_fish;
        $result->contact_name = $item->legal->contact_name;
        $result->contact_phone = $item->legal->contact_phone;
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateIndividual(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new IndividualClientDataObject($item->toArray());
            $result->first_name = $item->individual->first_name;
            $result->last_name = $item->individual->last_name;
            $result->middle_name = $item->individual->middle_name;
            $result->passport_seria = $item->individual->passport_seria;
            $result->passport_number = $item->individual->passport_number;
            return $result;
        };
        $entity_type = DictionaryItem::query()->where('name', '=', 'individual')->first();
        return $this->filterAndPaginate(
            Client::query()->where('entity_type_id', $entity_type->id),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateLegal(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new LegalClientDataObject($item->toArray());
            $result->name = $item->legal->name;
            $result->inn = $item->legal->inn;
            $result->company = $item->legal->company;
            $result->activity = $item->legal->activity;
            $result->okonx = $item->legal->okonx;
            $result->director_fish = $item->legal->director_fish;
            $result->contact_name = $item->legal->contact_name;
            $result->contact_phone = $item->legal->contact_phone;
            return $result;
        };

        $entity_type = DictionaryItem::query()->where('name', '=', 'legal')->first();
        return $this->filterAndPaginate(
            Client::query()->where('entity_type_id', $entity_type->id),
            $page,
            $limit,
            $closure,
            $filters
        );
    }
}
