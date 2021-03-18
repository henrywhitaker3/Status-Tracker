<?php

namespace Tests\Feature\Listeners;

use App\Events\ServiceCheckFailedEvent;
use App\Listeners\ServiceCheckFailedListener;
use App\Models\Service;
use App\Models\ServiceCheck;
use App\Models\Setting;
use App\Notifications\Discord\ServiceDownNotification as DiscordNotification;
use App\Notifications\Slack\ServiceDownNotification as SlackNotification;
use Cache;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Tests\TestCase;

class ServiceCheckFailedListenerTest extends TestCase
{
    private Service $service;

    private ServiceCheck $serviceCheck;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->serviceCheck = ServiceCheck::factory()->create(['up' => false]);
        $this->service = $this->serviceCheck->service;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_increments_the_cache_when_failing()
    {
        Cache::put($this->service->getFailedJobsCacheKey(), 0);
        $this->service->status = false;

        $event = new ServiceCheckFailedEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckFailedListener();
        $listener->handle($event);

        $this->assertEquals(1, Cache::get($this->service->getFailedJobsCacheKey()));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_sends_a_service_down_notification_when_it_fails_and_cache_is_equal_to_the_threshold()
    {
        $this->service->status = false;
        Setting::whereIn('name', ['Slack webhook', 'Discord webhook'])->update(['value' => 'test']);
        Setting::$settings = [];

        $event = new ServiceCheckFailedEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckFailedListener();
        $listener->handle($event);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            SlackNotification::class
        );
        Notification::assertSentTo(
            new AnonymousNotifiable,
            DiscordNotification::class
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_doesnt_send_notifications_every_time_it_fails_after_having_failed_once()
    {
        $this->service->status = false;
        Setting::whereIn('name', ['Slack webhook', 'Discord webhook'])->update(['value' => 'test']);
        Setting::$settings = [];

        $event = new ServiceCheckFailedEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckFailedListener();
        $listener->handle($event);
        $listener->handle($event);
        $listener->handle($event);

        Notification::assertSentToTimes(
            new AnonymousNotifiable,
            SlackNotification::class,
            1
        );
        Notification::assertSentTo(
            new AnonymousNotifiable,
            DiscordNotification::class,
            1
        );
    }

    public function test_it_updates_the_status_changed_field_when_it_fails()
    {
        $this->service->status = true;
        $original = $this->service->status_changed_at;

        sleep(1); // do this to force >1 second to pass so status_changed_at can update

        $event = new ServiceCheckFailedEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckFailedListener();
        $listener->handle($event);

        $this->assertNotEquals(
            Service::find($this->service->id)->status_chaged_at,
            $original
        );
    }

    public function test_it_doesnt_update_the_status_changed_field()
    {
        $this->service->status = false;
        $this->service->status_changed_at = Carbon::now();
        $this->service->save();
        $original = Service::find($this->service->id)->status_chaged_at;

        sleep(1); // do this to force >1 second to pass so status_changed_at can update

        $event = new ServiceCheckFailedEvent($this->service, $this->serviceCheck);

        $listener = new ServiceCheckFailedListener();
        $listener->handle($event);

        $this->assertEquals(
            Service::find($this->service->id)->status_chaged_at,
            $original
        );
    }
}
