<?php

namespace Tests\Feature\Actions;

use App\Actions\DispatchServiceChecks;
use App\Jobs\HttpServiceCheckJob;
use App\Jobs\PingServiceCheckJob;
use App\Jobs\ServiceCheckJob;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Queue;
use Tests\TestCase;

class DispatchServiceChecksActionTest extends TestCase
{
    /**
     * Test a job is dispatched to queue.
     *
     * @return void
     */
    public function test_it_dispatches_jobs()
    {
        Queue::fake();

        Service::factory()->create([
            'enabled' => true,
            'type' => 'http'
        ]);
        Service::factory()->create([
            'enabled' => true,
            'type' => 'ping'
        ]);

        $output = run(DispatchServiceChecks::class);

        $this->assertEquals(2, $output);

        Queue::assertPushed(PingServiceCheckJob::class);
        Queue::assertPushed(HttpServiceCheckJob::class);
    }
}
