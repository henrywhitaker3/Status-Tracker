<?php

namespace Tests\Feature\Actions;

use App\Actions\CheckServiceAction;
use App\Actions\ServiceCheckJobFailedAction;
use App\Models\Service;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Mocks\MockHttpServiceChecker;
use Tests\Mocks\MockPingServiceChecker;
use Tests\Mocks\MockServiceChecker;
use Tests\TestCase;

class ServiceCheckActionsTest extends TestCase
{
    use WithFaker;

    /**
     * Test running a successful http service check.
     *
     * @return void
     */
    public function test_check_service_action_pass_http()
    {
        $service = Service::factory()->create([
            'type' => 'http'
        ]);

        $action = new CheckServiceAction(
            new MockHttpServiceChecker(true),
            new MockPingServiceChecker(true),
        );
        $check = $action->run($service);

        $this->assertEquals(
            true,
            $check->up
        );
    }

    /**
     * Test running a successful ping service check.
     *
     * @return void
     */
    public function test_check_service_action_pass_ping()
    {
        $service = Service::factory()->create([
            'type' => 'ping'
        ]);

        $action = new CheckServiceAction(
            new MockHttpServiceChecker(true),
            new MockPingServiceChecker(true),
        );
        $check = $action->run($service);

        $this->assertEquals(
            true,
            $check->up
        );
    }

    /**
     * Test running a failing http service check.
     *
     * @return void
     */
    public function test_check_service_action_fail_http()
    {
        $service = Service::factory()->create([
            'type' => 'http'
        ]);

        $action = new CheckServiceAction(
            new MockHttpServiceChecker(false),
            new MockPingServiceChecker(true),
        );
        $check = $action->run($service);

        $this->assertEquals(
            false,
            $check->up
        );
    }

    /**
     * Test running a failing ping service check.
     *
     * @return void
     */
    public function test_check_service_action_fail_ping()
    {
        $service = Service::factory()->create([
            'type' => 'ping'
        ]);

        $action = new CheckServiceAction(
            new MockHttpServiceChecker(true),
            new MockPingServiceChecker(false),
        );
        $check = $action->run($service);

        $this->assertEquals(
            false,
            $check->up
        );
    }

    /**
     * Test service check job failed action.
     *
     * @return void
     */
    public function test_check_service_action_failed_job_action()
    {
        $service = Service::factory()->create();
        $exception = new Exception(
            $this->faker->words(10, true),
            500
        );

        $check = run(
            ServiceCheckJobFailedAction::class,
            $service,
            $exception
        );

        $this->assertEquals(
            $exception->getMessage(),
            $check->response_body
        );
        $this->assertEquals(
            $exception->getCode(),
            $check->response_code
        );
    }
}
