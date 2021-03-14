<?php

namespace App\Actions;

use App\Models\Service;
use App\Utils\ServiceChecker;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface as Action;

class CheckServiceAction implements Action
{
    private ServiceChecker $checker;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(ServiceChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Run a service check.
     *
     * @return mixed
     */
    public function run(Service $service = null)
    {
        $check = $this->checker->check($service);

        if ($service->status !== $check->up) {
            $service->status = $check->up;
            $service->status_changed_at = Carbon::now();
            $service->save();
        }

        return $check;
    }
}
