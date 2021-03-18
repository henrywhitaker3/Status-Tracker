<?php

namespace App\Listeners;

use App\Actions\Notifications\ServiceUpNotificationAction;
use App\Models\Service;
use App\Models\ServiceCheck;
use Cache;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceCheckSucceededListener
{
    private Service $service;

    private ServiceCheck $serviceCheck;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->service = $event->service;
        $this->serviceCheck = $event->serviceCheck;
        Cache::put($this->service->getFailedJobsCacheKey(), 0);

        if ($this->hasStatusChanged()) {
            $this->service->status_changed_at = Carbon::now();
            $this->service->status = true;
            $this->service->save();

            run(ServiceUpNotificationAction::class, $this->service, $this->serviceCheck);
        }
    }

    private function hasStatusChanged(): bool
    {
        if ($this->service->status !== $this->serviceCheck->up) {
            return true;
        }

        return false;
    }
}
