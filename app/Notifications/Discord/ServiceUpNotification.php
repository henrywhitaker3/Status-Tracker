<?php

namespace App\Notifications\Discord;

use App\Models\Service;
use App\Models\ServiceCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ServiceUpNotification extends Notification
{
    use Queueable;

    private Service $service;

    private ServiceCheck $serviceCheck;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Service $service, ServiceCheck $serviceCheck)
    {
        $this->service = $service;
        $this->serviceCheck = $serviceCheck;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the slack message.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toSlack($notifiable)
    {
        $service = $this->service;
        $serviceCheck = $this->serviceCheck;

        return (new SlackMessage())
            ->success()
            ->from('Checker')
            ->attachment(function ($attachment) use ($service, $serviceCheck) {
                $attachment->title($service->name . ' is Up')
                    ->fields([
                        'State' => 'Up',
                        'Type' => $service->type,
                        'Time' => $serviceCheck->created_at
                    ]);
            });
    }
}
