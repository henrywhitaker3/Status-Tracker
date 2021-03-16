<?php

namespace App\Actions\Notifications;

use App\Models\Service;
use App\Models\ServiceCheck;
use App\Models\Setting;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class SendServiceChangedNotification implements ActionInterface
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(Service $service = null, ServiceCheck $serviceCheck = null)
    {
        if ($service->shouldSendSlackNotification()) {
            $this->sendNotification('Slack', $service, $serviceCheck);
        }

        if ($service->shouldSendDiscordNotification()) {
            $this->sendNotification('Discord', $service, $serviceCheck);
        }
    }

    private function sendNotification(string $provider, Service $service, ServiceCheck $serviceCheck)
    {
        $class = $this->getNotificationClass($provider, $service->status);
        $notification = new $class($service, $serviceCheck);
        $property = strtolower($provider) . 'Notification';

        run(
            'App\Actions\Notifications\Send' . $provider . 'Notification',
            Setting::retrieve($provider . ' webhook', true),
            $notification
        );
    }

    private function getNotificationClass(string $provider, bool $status)
    {
        $startsWith = 'App\\Notifications\\' . $provider . '\\Service';
        $endsWith = 'Notification';

        if ($status === true) {
            $middle = 'Up';
        } else {
            $middle = 'Down';
        }

        return $startsWith . $middle . $endsWith;
    }
}
