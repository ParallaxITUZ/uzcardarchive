<?php

namespace App\Microservice\Services;

use App\ActionData\ClientContract\ClientContractActionData;
use App\ActionData\Invoice\InvoiceActionData;
use App\Microservice\DataObjects\Contract\ContractDataObject;
use App\Models\Invoice;
use App\Services\ClientContractService as AgentClientContractService;
use App\Services\ContractPolicyService;
use App\Services\InvoiceService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class ClientContractService
{
    private AgentClientContractService $service;
    private InvoiceService $invoiceService;
    private ContractPolicyService $contractPolicyService;

    /**
     * @param AgentClientContractService $service
     * @param InvoiceService $invoiceService
     * @param ContractPolicyService $contractPolicyService
     */
    public function __construct(
        AgentClientContractService $service,
        InvoiceService $invoiceService,
        ContractPolicyService $contractPolicyService
    )
    {
        $this->service = $service;
        $this->invoiceService = $invoiceService;
        $this->contractPolicyService = $contractPolicyService;
    }

    /**
     * @param ContractDataObject $object
     * @return array
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function create(ContractDataObject $object): array
    {
        $contract = ClientContractActionData::createFromArray($object->all());
        $result = $this->service->create($contract)->all();

        $actionData = InvoiceActionData::createFromArray([
            'type' => 1,
            'currency' => 1,
            'invoice_id' => $result['id'],
            'user_id' => $object->user_id
        ]);

        ini_set('memory_limit', '256M');

        $this->invoiceService->paid($actionData);

        $invoice = Invoice::query()->findOrFail($result['id']);
        $contract = $invoice->invoiceable;

        $policy = $this->contractPolicyService->getByContract($contract->id)->all();

        return [
            'risks_sum' => data_get($result, 'risks'),
            'amount' => $invoice->amount,
            'number' => data_get($policy, 'number'),
            'status' => true,
            'file' => asset('storage/' . $contract->file->path),
            'series' => data_get($policy, 'series'),
            'contract_id' => $contract->id
        ];
    }
}
