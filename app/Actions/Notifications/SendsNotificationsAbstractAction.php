<?php

namespace App\Actions\Notifications;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Models\Setting;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;
use Illuminate\Notifications\Notification;

abstract class SendsNotificationsAbstractAction implements ActionInterface
{
    protected function sendNotification(string $provider, Notification $notification)
    {
        run(
            'App\Actions\Notifications\Send' . $provider . 'Notification',
            Setting::retrieve($provider . ' webhook', true),
            $notification
        );
    }
}
