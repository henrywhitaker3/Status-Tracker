<?php

namespace App\Jobs;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ServiceCheckJob implements ShouldQueue
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
    public function handle()
    {
        $this->service->check();
    }

    public function failed()
    {
        $this->service->checks()->create([
            'response_code' => 0,
            'response_body' => 'The queue failed to check the service',
            'up' => false,
        ]);

        $this->service->status = false;
        $this->service->status_changed_at = Carbon::now();
        $this->service->save();
    }
}
