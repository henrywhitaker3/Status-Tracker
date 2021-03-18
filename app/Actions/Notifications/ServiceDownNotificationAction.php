<?php

namespace App\Actions\Notifications;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Notifications\Discord\ServiceDownNotification as DiscordNotification;
use App\Notifications\Slack\ServiceDownNotification as SlackNotification;

class ServiceDownNotificationAction extends SendsNotificationsAbstractAction
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(Service $service = null, ServiceCheck $serviceCheck = null)
    {
        if ($service->shouldSendDiscordNotification()) {
            $this->sendNotification(
                'Discord',
                new DiscordNotification($service, $serviceCheck)
            );
        }

        if ($service->shouldSendSlackNotification()) {
            $this->sendNotification(
                'Slack',
                new SlackNotification($service, $serviceCheck)
            );
        }
    }
}
