<?php

namespace App\Actions;

use App\Jobs\HttpServiceCheckJob;
use App\Jobs\PingServiceCheckJob;
use App\Jobs\ServiceCheckJob;
use App\Models\Service;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class DispatchServiceChecks implements ActionInterface
{
    /**
     * Dispatch a service check job for every service.
     *
     * @return mixed
     */
    public function run()
    {
        $services = Service::enabled()->get();

        foreach ($services as $service) {
            switch ($service->type) {
                case 'http':
                    dispatch(new HttpServiceCheckJob($service));
                    break;
                case 'ping':
                    dispatch(new PingServiceCheckJob($service));
                    break;
            }
        }

        return $services->count();
    }
}
