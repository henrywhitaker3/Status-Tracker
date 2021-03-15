<?php

namespace App\Actions\Notifications;

use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;
use Notification;
use Illuminate\Notifications\Notification as NotificationClass;

class SendDiscordNotification implements ActionInterface
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(string $webhook = null, NotificationClass $notification = null)
    {
        Notification::route('slack', $webhook . '/slack')
            ->notify($notification);
    }
}
