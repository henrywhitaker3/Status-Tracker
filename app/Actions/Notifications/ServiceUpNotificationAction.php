<?php

namespace App\Actions\Notifications;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Notifications\Discord\ServiceUpNotification as DiscordNotification;
use App\Notifications\Slack\ServiceUpNotification as SlackNotification;

class ServiceUpNotificationAction extends SendsNotificationsAbstractAction
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
