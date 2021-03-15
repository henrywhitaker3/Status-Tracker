<?php

namespace Tests\Feature\Actions;

use App\Actions\DeleteOldChecksAction;
use App\Models\ServiceCheck;
use Carbon\Carbon;
use Tests\TestCase;

class DeleteOldChecksActionTest extends TestCase
{
    /**
     * Tests a service check older than retention period
     * is deleted.
     *
     * @return void
     */
    public function test_it_deletes_old_service_check()
    {
        $check = ServiceCheck::factory()->create();
        $check->created_at = Carbon::now()->subDays(config('monitor.retention') + 10);
        $check->save();

        $this->assertNotNull(ServiceCheck::find($check->id));

        run(DeleteOldChecksAction::class);

        $this->assertNull(ServiceCheck::find($check->id));
    }

    /**
     * Tests a service check newer than retention period
     * is not deleted.
     *
     * @return void
     */
    public function test_it_doesnt_delete_new_service_check()
    {
        $check = ServiceCheck::factory()->create();

        $this->assertNotNull(ServiceCheck::find($check->id));

        run(DeleteOldChecksAction::class);

        $this->assertNotNull(ServiceCheck::find($check->id));
    }
}
