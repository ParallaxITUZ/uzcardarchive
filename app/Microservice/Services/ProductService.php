<?php

namespace App\Microservice\Services;

use App\Microservice\DataObjects\Product\ProductDataObject;
use App\Models\Product;
use App\Rabbitmq\Rabbit\Client;

class ProductService
{
    private Client $rabbitClient;

    /**
     * @param Client $rabbitClient
     */
    public function __construct(Client $rabbitClient)
    {
        $this->rabbitClient = $rabbitClient;
    }

    /**
     * @param ProductDataObject $object
     * @return array
     */
    public function getAll(ProductDataObject $object): array
    {
        $query = Product::query()->where('status', 1);

        foreach ($object->all() as $key => $value) {
            if (isset($value) && !empty($value)) {
                $query->where($key, $value);
            }
        }

        return $query->get([
            'name',
            'description',
            'id',
            'status'
        ])->toArray();
    }

    /**
     * @param ProductDataObject $object
     * @param string $method
     * @return void
     */
    private function publish(ProductDataObject $object, string $method)
    {
        $this->rabbitClient->setMessage([
            'method' => $method,
            'params' => $object->all()
        ], false)->publish('web-service');
    }

    /**
     * @param ProductDataObject $object
     * @return void
     */
    public function delete(ProductDataObject $object)
    {
        $object->status = false;
        $this->publish($object, 'deleteProduct');
    }

    /**
     * @param ProductDataObject $object
     * @return void
     */
    public function create(ProductDataObject $object)
    {
        $this->publish($object, 'addProduct');
    }

    /**
     * @param ProductDataObject $object
     * @return void
     */
    public function update(ProductDataObject $object)
    {
        $this->publish($object,'updateProduct');
    }
}
