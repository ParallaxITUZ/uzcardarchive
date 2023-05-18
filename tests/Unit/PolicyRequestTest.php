<?php

namespace Tests\Unit;

use App\ActionData\PolicyRequest\PolicyRequestActionData;
use App\ActionData\PolicyRequest\PolicyRequestApproveActionData;
use App\ActionResults\CommonActionResult;
use App\Models\PolicyRequest;
use App\Services\PolicyRequestService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PolicyRequestTest extends TestCase
{
    protected $service;

    /**
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->service = new PolicyRequestService();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateRequest()
    {
        $action_data = PolicyRequestActionData::items(5)->factory();
        $result = $this->service->create($action_data);
        if ($result instanceof CommonActionResult){
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testApproveRequest()
    {
        $action_data = PolicyRequestApproveActionData::factory();
        $result = $this->service->approve($action_data);
        if ($result instanceof CommonActionResult){
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testGetRequest()
    {
        $policy_request = PolicyRequest::query()->inRandomOrder()->first();
        $result = $this->service->get($policy_request->id);
        if ($result instanceof CommonActionResult){
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }
}
