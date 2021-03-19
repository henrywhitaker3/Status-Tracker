<?php

namespace Tests\Feature\Models;

use App\Models\Service;
use App\Models\ServiceCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_enabled_scope_only_returns_enabled_results()
    {
        Service::factory()->create(['enabled' => true]);
        Service::factory()->create(['enabled' => false]);

        $this->assertEquals(
            1,
            Service::enabled()->count()
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_total_checks_scope_returns_the_right_number()
    {
        $count = rand(5, 20);
        $service = Service::factory()->create(['enabled' => true]);
        ServiceCheck::factory()->count($count)->create(['service_id' => $service->id]);

        $this->assertEquals(
            $count,
            Service::withTotalChecks()->find($service->id)->total_checks
        );
    }
}
