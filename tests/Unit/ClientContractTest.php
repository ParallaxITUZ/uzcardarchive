<?php

namespace Tests\Unit;

use App\Services\ClientContractService;
use Tests\TestCase;

class ClientContractTest extends TestCase
{
    protected $service;

    /**
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
//        $this->service = new ClientContractService();
        parent::__construct($name, $data, $dataName);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
}
