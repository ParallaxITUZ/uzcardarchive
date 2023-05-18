<?php

namespace App\Services;

use App\ActionData\OSAGOEpolis\CostActionData;
use App\ActionData\OSAGOEpolis\DetailsActionData;
use App\ActionData\OSAGOEpolis\DriverActionData;
use App\ActionData\OSAGOEpolis\OsagoActionData;
use App\ActionData\OSAGOEpolis\OwnerActionData;
use App\ActionData\OSAGOEpolis\ObjectActionData as OsagoObjectActionData;
use App\ActionData\OSAGOEpolis\ConfigurationActionData as OsagoConfigurationActionData;
use App\ActionData\ReContract\ReContractActionData;
use App\ActionResults\VoidActionResult;
use App\Contracts\PaginatorInterface;
use App\Exceptions\CreationException;
use App\Models\ReContract;
use App\Services\Concerns\Paginator;
use Exception;
use Dompdf\Dompdf;
use App\Models\File;
use App\Models\Invoice;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductTariff;
use App\Models\ClientContract;
use App\Models\DictionaryItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\ActionData\ClientContract\ClientContractActionData;
use App\ActionData\Client\ClientActionData;
use App\ActionData\Travel\ConfigurationActionData;
use App\ActionData\Travel\ObjectActionData;
use App\ActionData\Travel\TravelActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\ClientContract\ClientContractDataObject;
use App\DataObjects\ContractAmount\ContractAmountDataObject;
use App\DataObjects\DataObjectPagination;
use App\Models\Client;
use Illuminate\Validation\ValidationException;

class ClientContractService implements PaginatorInterface
{
    use Paginator;

    public ProgramService $program_service;
    public OsagoFondService $osago_fond_service;
    public CalculatorService $calculator_service;
    public ClientService $client_service;

    /**
     *  ClientContractService constructor
     */
    public function __construct()
    {
        $this->program_service = new ProgramService();
        $this->osago_fond_service = new OsagoFondService();
        $this->calculator_service = new CalculatorService();
        $this->client_service = new ClientService();
    }

    /**
     * @param ClientContractActionData $action_data
     * @return ContractAmountDataObject
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(ClientContractActionData $action_data)
    {
        try {
            $action_data->validate();
            DB::beginTransaction();
            DB::table('client_contracts')->sharedLock()->get();

            $client_action_data = ClientActionData::createFromArray($action_data->client);
            $client_result = $this->client_service->create($client_action_data);
            $client_id = $client_result->id;
            $risks = [];

            switch ($action_data->product_id) {
                case ClientContract::PRODUCT_TRAVEL:
                    $configurations = ConfigurationActionData::createFromArray($action_data->configurations);
                    $configurations->validate();

                    $objects = $action_data->objects;
                    foreach ($objects as $object) {
                        $object = ObjectActionData::createFromArray($object);
                        $object->validate();
                    }

                    $birthdays = [];
                    foreach ($action_data->objects as $object) {
                        $birthdays[] = $object['birthdays'];
                    }
                    $travel_action_data = TravelActionData::createFromArray([
                        "product_tariff_id" => $configurations->product_tariff_id,
                        "begin_date" => $action_data->begin_date,
                        "end_date" => $configurations->end_date,
                        "dictionary_purpose_id" => $configurations->dictionary_purpose_id,
                        "is_family" => $configurations->is_family,
                        "multiple" => $configurations->multiple,
                        "multiple_type_id" => $configurations->multiple_type_id,
                        "birthdays" => $birthdays
                    ]);
                    $travel_action_data->validate();
                    $contract_amount = $this->calculator_service->travel($travel_action_data);
                    $risks = $this->getRiskCalculation($configurations->product_tariff_id);

                    $client_contract = ClientContract::create([
                        'product_id' => $action_data->product_id,
                        'product_tariff_id' => $configurations->product_tariff_id,
                        'begin_date' => $action_data->begin_date,
                        'end_date' => $configurations->end_date,
                        'status' => ClientContract::STATUS_PENDING,
                        'amount' => $contract_amount->uzs,
                        'risks_sum' => $risks,
                        'client_id' => $client_id,
                        'objects' => $action_data->objects,
                        'configurations' => $action_data->configurations,
                    ]);
                    break;
                case ClientContract::PRODUCT_OSAGO:
                    if (! isset($action_data->objects)) {
                        throw new Exception("Objects should contain multiple cars - NOT NESTED ARRAY EXCEPTION");
                    }

                    $object = OsagoObjectActionData::createFromArray($action_data->objects);
                    $object->validate();

                    $configurations_action_data = OsagoConfigurationActionData::createFromArray($action_data->configurations);
                    $configurations_action_data->validate();

                    $owner = OwnerActionData::createFromArray($configurations_action_data->owner);
                    $owner->validate();
                    $details = DetailsActionData::createFromArray($configurations_action_data->details);
                    $details->validate();

                    $cost = CostActionData::createFromArray($configurations_action_data->cost);
                    $cost->validate();

                    $drivers = $configurations_action_data->drivers;
                    foreach ($drivers as $dr) {
                        $driver = DriverActionData::createFromArray([
                            "pinfl" => $dr['passportData']['pinfl'],
                            "pass_series" => $dr['passportData']['seria'],
                            "pass_number" => $dr['passportData']['number'],
                            "pass_issued_by" => $dr['passportData']['issuedBy'],
                            "pass_issue_date" => $dr['passportData']['issueDate'],
                            "first_name" => $dr['fullName']['firstname'],
                            "last_name" => $dr['fullName']['lastname'],
                            "middle_name" => $dr['fullName']['middlename'],
                            "license_seria" => $dr['licenseSeria'],
                            "license_number" => $dr['licenseNumber'],
                            "relative" => $dr['relative'],
                            "license_issue_date" => $dr['licenseIssueDate'],
                            "birthday" => $dr['birthDate'],
                        ]);
                        $driver->validate();
                    }

                    $osago_action_data = OsagoActionData::createFromArray($configurations_action_data->all());

                    $this->osago_fond_service->checkReliability([
                        'pinfl' => $owner->pinfl,
                        'p_seria' => $owner->passport_series,
                        'p_number' => $owner->passport_number,
                        'gov_number' => $object->govNumber,
                        'pensioner' => $configurations_action_data->pensioner
                    ]);

                    $request_fond = $this->osago_fond_service
                        ->sendData($client_action_data, $owner, $drivers, $details, $cost, $object);

                    $action_data->configurations['uuid'] = $request_fond['uuid'];

                    $product_tariff = ProductTariff::query()->where('product_id', $action_data->product_id)->first();
                    $contract_amount = $this->calculator_service->osago($osago_action_data);

                    $client_contract = ClientContract::create([
                        'product_id' => $action_data->product_id,
                        'product_tariff_id' => $product_tariff->id,
                        'begin_date' => $details->start_date,
                        'end_date' => $details->end_date,
                        'status' => ClientContract::STATUS_PENDING,
                        'amount' => $contract_amount->uzs,
//                        'risks_sum' => $risks,
                        'client_id' => $client_id,
                        'objects' => $action_data->objects,
                        'configurations' => $action_data->configurations,
                    ]);
                    break;
                default:
                    $client_contract = null;
                    $contract_amount = null;
                    break;
            }
            if ($client_contract == null) {
                throw new Exception('Undefined Product');
            }

            $invoice = $client_contract->invoice()->create([
                'amount' => $client_contract->amount,
                'status' => Invoice::NOT_PAID,
            ]);

            DB::commit();

            return new ContractAmountDataObject([
                'id' => $invoice->id,
                'uzs' => $contract_amount->uzs,
                'usd' => $contract_amount->usd,
                'risks' => $risks
            ]);
        } catch (Exception $e) {
            info("Exception: " . $e->getMessage());
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param ReContractActionData $re_contract_action_data
     * @return CommonActionResult
     * @throws BindingResolutionException
     * @throws CreationException
     * @throws ValidationException
     */
    public function reContract(ReContractActionData $re_contract_action_data)
    {
        $re_contract_action_data->validate();
        $item = ClientContract::query()->findOrFail($re_contract_action_data->old_contract_id);
        if ($item->product_id != $re_contract_action_data->product_id){
            throw new Exception('Re contract product must be old contract product id');
        }
        $contract_action_data = ClientContractActionData::createFromArray([
            "product_id" => $re_contract_action_data->product_id,
            "configurations" => $re_contract_action_data->configurations,
            "client" => $re_contract_action_data->client,
            "objects" => $re_contract_action_data->objects,
            "begin_date" => $re_contract_action_data->begin_date,
        ]);
        $re_contract_result = $this->create($contract_action_data);
        if ($re_contract_result instanceof ContractAmountDataObject){
            $invoice = Invoice::query()->findOrFail($re_contract_result->id);
            ReContract::query()->create([
                'old_contract_id' => $re_contract_action_data->old_contract_id,
                'new_contract_id' => $invoice->contract_id,
                'reason_id'=>$re_contract_action_data->reason_id,
                'comment'=>$re_contract_action_data->comment,
            ]);
            return new CommonActionResult($re_contract_result->id);
        } else {
            throw new CreationException('Cannot create contract');
        }
    }

    /**
     * @param int $product_tariff_id
     * @return int
     */
    protected function getRiskCalculation(int $product_tariff_id): int
    {
        $risks = 0;
        foreach (ProductTariff::find($product_tariff_id)->risks as $risk) {
            $risks += $risk->amount;
        }
        return $risks;
    }

    /**
     * @throws ValidationException
     */
    public function update(ClientContractActionData $client_contract_action_data): CommonActionResult
    {
        $client_contract_action_data->validate();
        $client_contract = ClientContract::query()->where('id', $client_contract_action_data->id)->update([
            'product_id' => $client_contract_action_data->product_id,
            'begin_date' => $client_contract_action_data->begin_date,
            'end_date' => $client_contract_action_data->end_date,
            'client' => json_encode($client_contract_action_data->client),
            'objects' => json_encode($client_contract_action_data->objects)
        ]);
        return new CommonActionResult($client_contract->id);
    }

    public function delete(int $id)
    {
        ClientContract::query()->find($id)->delete();
        return new VoidActionResult();
    }

    public function get(Request $request)
    {

        $item = ClientContract::query()->findOrFail($request->id);
        $result = new ClientContractDataObject($item->toArray());
        $result->product = $item->product;
        $result->entity_type = $item->entity;
        $result->client = array_merge($item->client->first(['entity_type_id', 'address', 'phone'])->toArray(), [
            'individual' => $item->client->data()
        ]);
        $result->invoice = $item->invoice;
        $result->payment = $item->invoice->payment;
        $result->file = $item->file;
        $result->risks_sum = $item->risks_sum;
        return $result;
    }

    public function cancelContract(int $id)
    {
        $contract = ClientContract::query()->find($id);
        $invoice = $contract->invoice;
        $dompdf = new DOMPDF();
        $fname = Str::uuid() . '.pdf';
        $data = file_get_contents(base_path() . "/public/pdf/kafolat.svg");
        $countries = [];
        foreach ($invoice->invoiceable->configurations['countries'] as $country) {
            $object = DictionaryItem::query()->findOrFail($country);
            $countries[] = $object;
        }
        $html = view('canceled',
            [
                'base64' => base64_encode($data),
                'fname' => $fname,
                'contract' => $contract,
                'invoice' => $invoice,
                'countries' => $countries,
                'summ' => $contract->risks_sum,
                'root' => request()->root(),
            ]
        )->render();

        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::disk('local')->put('public/files/' . $fname, $dompdf->output());
        $invoice->update([
            'status' => Invoice::CANCELED
        ]);
        $contract->update([
            'status' => ClientContract::STATUS_DENIED
        ]);
        File::query()->create([
            'filename' => $fname,
            'path' => 'files/' . $fname,
            'extension' => 'pdf',
            'type' => 'client contract',
            'size' => Storage::disk('local')->size('public/files/' . $fname),
            'user_id' => Auth::user()->id
        ]);

        return new CommonActionResult($id);
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return CommonActionResult|DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new ClientContractDataObject($item->toArray());
            $result->product = $item->product;
            $result->client = array_merge($item->client->first(['entity_type_id', 'address', 'phone'])->toArray(), [
                'individual' => $item->client->data()
            ]);
            $result->invoice = $item->invoice;
            $result->payment = $item->invoice->payment;
            $result->file = $item->file;
            $result->risks_sum = $item->risks_sum;
            return $result;
        };

        return $this->filterAndPaginate(
            ClientContract::query(),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * @throws Exception
     */
    public function getClient(ClientActionData $client_action_data, $pinfl = null, $inn = null)
    {
        if ($pinfl == null && $inn == null) {
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
        }

        if (!$client) {
            $client = Client::query()->create([
                "entity_type_id" => $client_action_data->entity_type_id,
                "address" => $client_action_data->address,
                "phone" => $client_action_data->phone,
                "registered_user_id" => $client_action_data->registered_user_id,
            ]);
        }

        return $client;
    }
}
