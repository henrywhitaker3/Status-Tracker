<?php

namespace Tests\Feature\Jobs;

use App\Events\ServiceCheckFailedEvent;
use App\Events\ServiceCheckSucceededEvent;
use App\Jobs\HttpServiceCheckJob;
use App\Models\Service;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Mocks\MockHttpServiceChecker;
use Tests\TestCase;

class HttpServiceCheckJobTest extends TestCase
{
    /**
     * Test it runs a successful http job.
     *
     * @return void
     */
    public function test_a_http_jobs_raises_a_success_event()
    {
        Event::fake();

        $service = Service::factory()->create(['type' => 'http']);

        $job = new HttpServiceCheckJob($service);
        $job->handle(new MockHttpServiceChecker(true));

        Event::assertDispatched(ServiceCheckSucceededEvent::class);
    }

    /**
     * Test it runs a failed http job.
     *
     * @return void
     */
    public function test_a_bad_http_jobs_raises_a_fail_event()
    {
        Event::fake();

        $service = Service::factory()->create(['type' => 'http']);

        $job = new HttpServiceCheckJob($service);
        $job->handle(new MockHttpServiceChecker(false));

        Event::assertDispatched(ServiceCheckFailedEvent::class);
    }
}
