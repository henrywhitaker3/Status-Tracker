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
