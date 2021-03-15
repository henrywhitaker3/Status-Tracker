<?php

namespace Tests\Feature\Actions\Notifications;

use App\Actions\Notifications\SendDiscordNotification;
use App\Actions\Notifications\SendSlackNotification;
use App\Models\ServiceCheck;
use App\Notifications\Discord\ServiceDownNotification as DiscordNotification;
use App\Notifications\Slack\ServiceDownNotification as SlackNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Tests\TestCase;

class SendNotificationsTest extends TestCase
{
    /**
     * Test a notification of type slack message is sent.
     *
     * @return void
     */
    public function test_it_sends_a_discord_notification()
    {
        Notification::fake();

        $check = ServiceCheck::factory()->create();

        $notification = new DiscordNotification($check->service, $check);

        run(SendDiscordNotification::class, 'test', $notification);

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            DiscordNotification::class
        );
    }

    /**
     * Test a notification of type slack message is sent.
     *
     * @return void
     */
    public function test_it_sends_a_slack_notification()
    {
        Notification::fake();

        $check = ServiceCheck::factory()->create();

        $notification = new SlackNotification($check->service, $check);

        run(SendSlackNotification::class, 'test', $notification);

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            SlackNotification::class
        );
    }
}
