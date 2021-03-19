<?php

namespace Tests\Feature\Utils;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Utils\HttpServiceChecker;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpServiceCheckerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_service_check_object_when_successful()
    {
        $service = Service::factory()->create(['type' => 'http']);
        $client = $this->mockClient(200, 'Ok');

        $checker = new HttpServiceChecker($client);
        $serviceCheck = $checker->check($service);

        $this->assertInstanceOf(
            ServiceCheck::class,
            $serviceCheck
        );
        $this->assertTrue($serviceCheck->up);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_service_check_object_when_failed()
    {
        $service = Service::factory()->create(['type' => 'http']);
        $client = $this->mockClient(500, 'Not Ok');

        $checker = new HttpServiceChecker($client);
        $serviceCheck = $checker->check($service);

        $this->assertInstanceOf(
            ServiceCheck::class,
            $serviceCheck
        );
        $this->assertFalse($serviceCheck->up);
    }

    private function mockClient(int $code, string $message)
    {
        $mockClient = new MockHandler([
            new Response($code, [], $message)
        ]);

        $handlerStack = HandlerStack::create($mockClient);

        return new Client(['handler' => $handlerStack]);
    }
}
