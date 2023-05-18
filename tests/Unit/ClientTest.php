<?php

namespace Tests\Unit;

use App\Services\ClientService;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected $service;

    /**
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->service = new ClientService();
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
