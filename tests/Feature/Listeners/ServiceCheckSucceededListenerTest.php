<?php

namespace Tests\Feature\Listeners;

use App\Events\ServiceCheckSucceededEvent;
use App\Listeners\ServiceCheckSucceededListener;
use App\Models\Service;
use App\Models\ServiceCheck;
use App\Models\Setting;
use App\Notifications\Slack\ServiceUpNotification as SlackServiceUpNotification;
use App\Notifications\Discord\ServiceUpNotification as DiscordServiceUpNotification;
use Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Tests\TestCase;

class ServiceCheckSucceededListenerTest extends TestCase
{
    private Service $service;

    private ServiceCheck $serviceCheck;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Cache::clear();

        $this->serviceCheck = ServiceCheck::factory()->create(['up' => true]);
        $this->service = $this->serviceCheck->service;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_does_nothing_when_status_is_already_up()
    {
        $this->service->status = true;
        $event = new ServiceCheckSucceededEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckSucceededListener();
        $listener->handle($event);

        Notification::assertNothingSent();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_sets_the_cache_to_0_when_up()
    {
        $this->service->status = true;
        Cache::put($this->service->getFailedJobsCacheKey(), 5);

        $event = new ServiceCheckSucceededEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckSucceededListener();
        $listener->handle($event);

        $this->assertEquals(0, Cache::get($this->service->getFailedJobsCacheKey()));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_sends_a_notification_when_the_status_has_changed()
    {
        $this->service->status = false;
        Setting::whereIn('name', ['Slack webhook', 'Discord webhook'])->update(['value' => 'test']);
        Setting::$settings = [];

        $event = new ServiceCheckSucceededEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckSucceededListener();
        $listener->handle($event);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            SlackServiceUpNotification::class,
        );

        Notification::assertSentTo(
            new AnonymousNotifiable,
            DiscordServiceUpNotification::class,
        );
    }

    public function test_it_updates_status_changed_at_when_it_succeeds()
    {
        $this->service->status = false;
        $original = $this->service->status_changed_at;
        sleep(1); // do this to force >1 second to pass so status_changed_at can update

        $event = new ServiceCheckSucceededEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckSucceededListener();
        $listener->handle($event);

        $this->assertNotEquals(
            Service::find($this->service->id)->status_changed_at,
            $original
        );
    }

    public function test_it_doesnt_update_status_changed_at()
    {
        $this->service->status = true;
        $original = $this->service->status_changed_at;

        sleep(1); // do this to force >1 second to pass so status_changed_at can update

        $event = new ServiceCheckSucceededEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckSucceededListener();
        $listener->handle($event);

        $this->assertEquals(
            Service::find($this->service->id)->status_changed_at,
            $original
        );
    }
}
