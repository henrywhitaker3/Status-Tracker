<?php

namespace App\Listeners;

use App\Actions\Notifications\ServiceDownNotificationAction;
use App\Models\Service;
use App\Models\ServiceCheck;
use App\Models\Setting;
use Cache;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceCheckFailedListener
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
        $cacheKey = 'failed-check-' . $this->service->id;

        Cache::increment($cacheKey, 1);

        if ($this->hasStatusChanged()) {
            $this->service->status_changed_at = Carbon::now();
            $this->service->status = false;
            $this->service->save();
        }

        if ((int)Cache::get($cacheKey, 0) >= Setting::retrieve('Alert threshold', true)) {
            run(ServiceDownNotificationAction::class, $this->service, $this->serviceCheck);
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
