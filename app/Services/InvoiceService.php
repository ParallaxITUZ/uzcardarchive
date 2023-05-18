<?php

namespace App\Services;

use App\ActionData\ContractPolicy\ContractPolicyActionData;
use App\ActionData\Invoice\InvoiceActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\OsagoActionResult;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Invoice\InvoiceDataObject;
use App\Exceptions\NotFoundException;
use App\Microservice\DataObjects\Billing\WalletObject;
use App\Microservice\Services\BillingService;
use App\Models\ClientContract;
use App\Models\ContractPolicy;
use App\Models\DictionaryItem;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Payment;
use Dompdf\Dompdf;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    public OsagoFondService $osago_fond_service;
    public ContractPolicyService $contract_policy_service;
    public BillingService $billing_service;

    /**
     * InvoiceService constructor
     */
    public function __construct()
    {
        $this->osago_fond_service = new OsagoFondService();
        $this->contract_policy_service = new ContractPolicyService();
    }

    public function paginate($page = 1, $limit = 25, ?iterable $filters = null){
        $policy = Invoice::query()->latest()->where('is_deleted', '=', false)->paginate($limit);
        $items = $policy->getCollection()->transform(function ($item){
            $result = new InvoiceDataObject($item->toArray());
            $result->contract = $item->contract;
            $result->payment = $item->payment;
            return $result;
        });
        return new DataObjectPagination($items, $policy->total(), $limit, $page);
    }

    /**
     * @param InvoiceActionData $action_data
     * @return CommonActionResult|OsagoActionResult
     * @throws NotFoundException
     * @throws GuzzleException
     * @throws BindingResolutionException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function paid(InvoiceActionData $action_data)
    {
        try {
            DB::beginTransaction();
            $invoice = Invoice::query()->findOrFail($action_data->invoice_id);
            $contract = $invoice->invoiceable;
            if (!$contract) {
                throw new NotFoundException('Contract not found');
            }
            Payment::query()->create([
                'invoice_id' => $invoice->id,
                'amount' => $invoice->amount,
                'type' => $action_data->type,
                'currency' => $action_data->currency,
                'status' => Payment::PAID,
            ]);
            $invoice->update([
                'status' => Invoice::PAID
            ]);

            switch ($contract->product_id) {
                case ClientContract::PRODUCT_TRAVEL:
                    $contract_policy_action_data = ContractPolicyActionData::createFromArray([
                        'contract_id' => $contract->id
                    ]);
                    $contract_policy_result = $this->contract_policy_service->create($contract_policy_action_data);
                    $contract_policy = ContractPolicy::query()->findOrFail($contract_policy_result->id);
                    $dompdf = new DOMPDF();
                    $fname = Str::uuid() . '.pdf';
                    $data = file_get_contents(base_path() . "/public/pdf/kafolat.svg");
                    $countries = [];
                    foreach ($invoice->invoiceable->configurations['countries'] as $country) {
                        $object = DictionaryItem::query()->findOrFail($country);
                        $countries[] = $object;
                    }
                    $html = view('pdf',
                        [
                            'base64' => base64_encode($data),
                            'fname' => $fname,
                            'contract' => $contract,
                            'client' => $contract->client,
                            'contract_policy' => $contract_policy,
                            'invoice' => $invoice,
                            'countries' => $countries,
                            'summ' => $contract->risks_sum,
                            'root' => request()->root(),
                        ]
                    )->render();

                    $dompdf->loadHtml($html);
                    $dompdf->render();
                    Storage::disk('local')->put('public/files/' . $fname, $dompdf->output());
                    $file = File::query()->create([
                        'filename' => $fname,
                        'path' => 'files/' . $fname,
                        'extension' => 'pdf',
                        'type' => 'client contract',
                        'size' => Storage::disk('local')->size('public/files/' . $fname),
                        'user_id' => Auth::user()->id ?? 1
                    ]);
                    $contract->update([
                        'file_id' => $file->id
                    ]);
                    break;
                case ClientContract::PRODUCT_OSAGO:
                    $confirm_payment = $this->osago_fond_service->confirmPayment($contract);

                    ContractPolicy::query()->create([
                        "contract_id" => $contract->id,
                        "series" => $confirm_payment["seria"],
                        "number" => $confirm_payment["number"]
                    ]);

                    if ($confirm_payment) {
                        $contract->update([
                            'status' => ClientContract::STATUS_ACTIVE,
                        ]);
                    }

                    return new OsagoActionResult($contract->configurations['uuid']);
                default:
                    throw new NotFoundException("Doesn't have product with id=$contract->product_id");
            }
            DB::commit();
            return new CommonActionResult($file->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function cancelPayment(int $id)
    {
        $invoice = Invoice::query()->findOrFail($id);
        $payment = $invoice->invoiceable;
        $invoice->update([
            'status' => Invoice::CANCELED
        ]);
        if ($payment) {
            $payment->update([
                'status' => Payment::RETURNED
            ]);
        }
        return new CommonActionResult($invoice->id);
    }

    /**
     * @param \App\Models\Invoice $invoice
     * @param int $from
     * @param int $to
     * @return bool
     * @throws \ErrorException
     * @throws \Illuminate\Validation\ValidationException
     */
    private function createTransaction(Invoice $invoice, int $from, int $to): bool {
        $result = $this->billing_service->siteIncoming(new WalletObject([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'from' => [
                'account' => $this->getDepositAccount($from)
            ],
            'tor' => [
                'account' => $this->getDepositAccount($to)
            ],
        ]));
        return data_get($result, 'success');
    }

    private function getDepositAccount(int $id): string {
        $organization = Organization::query()->findOrFail($id);
        return str_pad($organization->company_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($organization->filial_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($organization->branch_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($organization->agent_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($organization->sub_agent_number, 4, '0', STR_PAD_LEFT);
    }
}
