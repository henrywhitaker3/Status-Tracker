<?php

namespace App\Actions;

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
        $services = Service::get();

        foreach ($services as $service) {
            dispatch(new ServiceCheckJob($service));
        }
    }
}
