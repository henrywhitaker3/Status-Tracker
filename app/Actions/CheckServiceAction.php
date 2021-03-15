<?php

namespace App\Actions;

use App\Models\Service;
use App\Utils\HttpServiceChecker;
use App\Utils\PingServiceChecker;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface as Action;

class CheckServiceAction implements Action
{
    private HttpServiceChecker $httpChecker;

    private PingServiceChecker $pingChecker;

    private array $checkerMaps;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(
        HttpServiceChecker $httpChecker,
        PingServiceChecker $pingChecker
    ) {
        $this->httpChecker = $httpChecker;
        $this->pingChecker = $pingChecker;
    }

    /**
     * Run a service check.
     *
     * @return mixed
     */
    public function run(Service $service = null)
    {
        $checker = $service->type . 'Checker';

        $check = $this->$checker->check($service);

        if ($service->status !== $check->up) {
            $service->status = $check->up;
            $service->status_changed_at = Carbon::now();
            $service->save();
        }

        return $check;
    }
}
