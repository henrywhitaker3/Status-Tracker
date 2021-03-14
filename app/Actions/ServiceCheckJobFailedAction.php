<?php

namespace App\Actions;

use App\Models\Service;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class ServiceCheckFailedAction implements ActionInterface
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(Service $service = null)
    {
        return run(
            ServiceCheckFailedAction::class,
            $service,
            0,
            'The queue failed to check the service'
        );
    }
}
