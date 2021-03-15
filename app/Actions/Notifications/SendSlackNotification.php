<?php

namespace App\Actions\Notifications;

use Exception;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;
use Notification;
use Illuminate\Notifications\Notification as NotificationClass;

class SendSlackNotification implements ActionInterface
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(string $webhook = null, NotificationClass $notification = null)
    {
        try {
            Notification::route('slack', $webhook)
                ->notify($notification);
        } catch (Exception $e) {
            //
        }
    }
}
