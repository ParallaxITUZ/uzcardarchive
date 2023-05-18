<?php

namespace App\Microservice\Services;

use App\DataObjects\BaseDataObject;
use App\Microservice\DataObjects\Billing\OrganizationObject;
use App\Microservice\DataObjects\Billing\WalletObject;
use App\Microservice\DataObjects\Billing\WalletOperationObject;
use App\Rabbitmq\Rabbit\Client;
use ErrorException;
use Exception;
use Illuminate\Validation\ValidationException;

class BillingService
{
    /**
     * @var Client
     */
    private Client $rabbitClient;

    /**
     * @param Client $rabbitClient
     * @throws Exception
     */
    public function __construct(Client $rabbitClient)
    {
        $this->rabbitClient = $rabbitClient;
    }

    /**
     * @param WalletObject|WalletOperationObject $object
     * @param string $method
     * @return array|string
     * @throws ErrorException
     */
    public function publish(BaseDataObject $object, string $method)
    {
        return $this->rabbitClient->open()->setMessage([
            'method' => $method,
            'params' => $object->all(true)
        ])->request()->getResult();
    }

    /**
     * @param OrganizationObject $object
     * @return array|string
     * @throws ErrorException
     * @throws ValidationException
     */
    public function updateOrCreateOrganization(OrganizationObject $object)
    {
        if (!$object->validate()) {
            return ['success' => false, 'message' => $object->getValidationErrors()->toArray()];
        }

        return $this->publish($object, 'updateOrCreateOrganization');
    }

    /**
     * @param WalletObject $object
     * @return array|string
     * @throws ErrorException
     */
    public function siteIncoming(WalletObject $object)
    {
        if (!$object->validate()) {
            return ['success' => false, 'message' => $object->getValidationErrors()->toArray()];
        }

        $object->from = $object->from->all();
        $object->to = $object->to->all();
        return $this->publish($object,'siteIncoming');
    }

    /**
     * @param WalletObject $object
     * @return array|string
     * @throws ErrorException
     */
    public function agentIncoming(WalletObject $object)
    {
        if (!$object->validate()) {
            return ['success' => false, 'message' => $object->getValidationErrors()->toArray()];
        }

        $object->from = $object->from->all();
        $object->to = $object->to->all();
        return $this->publish($object,'agentIncoming');
    }

    /**
     * @param WalletObject $object
     * @return array|string
     * @throws ErrorException
     */
    public function otherIncoming(WalletObject $object)
    {
        if (!$object->validate()) {
            return ['success' => false, 'message' => $object->getValidationErrors()->toArray()];
        }

        $object->from = $object->from->all();
        $object->to = $object->to->all();
        return $this->publish($object,'agentIncoming');
    }

    /**
     * @param WalletObject $object
     * @return WalletObject
     * @throws ErrorException
     */
    public function getBalance(WalletObject $object): WalletObject
    {
        $result = $this->rabbitClient->setMessage([
            'method' => 'getBalance',
            'params' => $object->filter
        ])->request()->getResult();

        return new $object($result);
    }

    /**
     * @param WalletObject $object
     * @return WalletObject
     * @throws ErrorException
     */
    public function getHistory(WalletObject $object): WalletObject
    {
        $result = $this->rabbitClient->setMessage([
            'method' => 'getHistory',
            'params' => $object->filter
        ])->request()->getResult();

        return new $object($result);
    }

    /**
     * @param WalletObject $object
     * @return WalletObject
     * @throws ErrorException
     */
    public function getInvoiceHistory(WalletObject $object): WalletObject
    {
        $result = $this->rabbitClient->setMessage([
            'method' => 'getInvoiceHistory',
            'params' => $object->filter
        ])->request()->getResult();

        return new $object($result);
    }
}
