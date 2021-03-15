<?php

namespace Tests\Feature\Actions;

use App\Actions\DispatchServiceChecks;
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
    public function test_job_is_dispatched()
    {
        Queue::fake();

        Service::factory()->create([
            'enabled' => true
        ]);

        $output = run(DispatchServiceChecks::class);

        $this->assertEquals(1, $output);
        Queue::assertPushed(ServiceCheckJob::class);
    }
}
