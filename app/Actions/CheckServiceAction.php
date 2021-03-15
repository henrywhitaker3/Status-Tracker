<?php

namespace App\Actions;

use App\Actions\Notifications\SendServiceChangedNotification;
use App\Interfaces\ServiceCheckerInterface;
use App\Models\Service;
use App\Models\ServiceCheck;
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
        $check = $this->getChecker($service)->check($service);

        if ($this->hasStatusChanged($service, $check)) {
            $this->updateStatus($service, $check);
        }

        return $check;
    }

    /**
     * Determines whether the status has changed.
     *
     * @param Service $service
     * @param ServiceCheck $serviceCheck
     * @return bool
     */
    private function hasStatusChanged(Service $service, ServiceCheck $serviceCheck): bool
    {
        if ($service->status === $serviceCheck->up) {
            return false;
        }

        return true;
    }

    /**
     * Updates the status and does notifiying.
     *
     * @param Service $service
     * @param ServiceCheck $serviceCheck
     * @return void
     */
    private function updateStatus(Service $service, ServiceCheck $serviceCheck)
    {
        $service->status = $serviceCheck->up;
        $service->status_changed_at = Carbon::now();
        $service->save();

        run(SendServiceChangedNotification::class, $service, $serviceCheck);
    }

    /**
     * Return the correct service checker.
     *
     * @param Service $service
     * @return ServiceCheckerInterface
     */
    private function getChecker(Service $service): ServiceCheckerInterface
    {
        $checker = $service->type . 'Checker';

        return $this->$checker;
    }
}
