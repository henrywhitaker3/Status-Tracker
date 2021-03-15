<?php

namespace App\Actions;

use App\Models\Service;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;
use Throwable;

class ServiceCheckJobFailedAction implements ActionInterface
{
    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(Service $service = null, Throwable $e = null)
    {
        return run(
            ServiceCheckFailedAction::class,
            $service,
            $e->getCode(),
            $e->getMessage(),
        );
    }
}
