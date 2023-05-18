<?php

namespace Tests\Unit;

use App\Services\PolicyTransferService;
use Tests\TestCase;

class PolicyTransferTest extends TestCase
{
    protected $service;

    /**
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->service = new PolicyTransferService();
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
