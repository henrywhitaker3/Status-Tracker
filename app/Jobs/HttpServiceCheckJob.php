<?php

namespace App\Jobs;

use App\Events\ServiceCheckFailedEvent;
use App\Events\ServiceCheckSucceededEvent;
use App\Models\Service;
use App\Utils\HttpServiceChecker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class HttpServiceCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Service $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(HttpServiceChecker $httpChecker)
    {
        $serviceCheck = $httpChecker->check($this->service);

        if (!$serviceCheck->up) {
            event(new ServiceCheckFailedEvent($this->service, $serviceCheck));
            return;
        }

        event(new ServiceCheckSucceededEvent($this->service, $serviceCheck));
    }

    public function failed(Throwable $e)
    {
        $serviceCheck = run(ServiceCheckJobFailedAction::class, $this->service, $e);
        event(new ServiceCheckFailedEvent($this->service, $serviceCheck));
    }
}
