<?php

namespace Tests\Feature\Utils;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Utils\PingServiceChecker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Mocks\MockPingCommandWrapper;
use Tests\TestCase;

class PingServiceCheckerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_creates_a_service_check_action()
    {
        $service = Service::factory()->create(['type' => 'ping']);
        $wrapper = new MockPingCommandWrapper(true);

        $checker = new PingServiceChecker($wrapper);
        $check = $checker->check($service);

        $this->assertInstanceOf(
            ServiceCheck::class,
            $check
        );
        $this->assertTrue($check->up);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_creates_a_failed_service_check_action()
    {
        $service = Service::factory()->create(['type' => 'ping']);
        $wrapper = new MockPingCommandWrapper(false);

        $checker = new PingServiceChecker($wrapper);
        $check = $checker->check($service);

        $this->assertInstanceOf(
            ServiceCheck::class,
            $check
        );
        $this->assertFalse($check->up);
    }
}
