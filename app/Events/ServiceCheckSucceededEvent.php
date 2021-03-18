<?php

namespace App\Events;

use App\Models\Service;
use App\Models\ServiceCheck;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceCheckSucceededEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Service $service;

    public ServiceCheck $serviceCheck;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Service $service, ServiceCheck $serviceCheck)
    {
        $this->service = $service;
        $this->serviceCheck = $serviceCheck;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
