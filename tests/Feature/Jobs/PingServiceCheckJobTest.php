<?php

namespace Tests\Feature\Jobs;

use App\Events\ServiceCheckFailedEvent;
use App\Events\ServiceCheckSucceededEvent;
use App\Jobs\PingServiceCheckJob;
use App\Models\Service;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Queue;
use Tests\Mocks\MockPingServiceChecker;
use Tests\TestCase;

class PingServiceCheckJobTest extends TestCase
{
    /**
     * Test it runs a successful ping job.
     *
     * @return void
     */
    public function test_a_ping_jobs_raises_a_success_event()
    {
        Event::fake();

        $service = Service::factory()->create(['type' => 'ping']);

        $job = new PingServiceCheckJob($service);
        $job->handle(new MockPingServiceChecker(true));

        Event::assertDispatched(ServiceCheckSucceededEvent::class);
    }

    /**
     * Test it runs a failed ping job.
     *
     * @return void
     */
    public function test_a_bad_ping_jobs_raises_a_fail_event()
    {
        Event::fake();

        $service = Service::factory()->create(['type' => 'ping']);

        $job = new PingServiceCheckJob($service);
        $job->handle(new MockPingServiceChecker(false));

        Event::assertDispatched(ServiceCheckFailedEvent::class);
    }
}
