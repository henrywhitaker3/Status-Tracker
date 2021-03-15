<?php

namespace App\Actions;

use App\Models\Service;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class ServiceCheckFailedAction implements ActionInterface
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Run the action.
     *
     * @return mixed
     */
    public function run(
        Service $service = null,
        int $statusCode = null,
        string $message = null
    ) {
        if ($service->status !== false) {
            $service->status = false;
            $service->status_changed_at = Carbon::now();
            $service->save();
        }

        return $service->checks()->create([
            'up' => false,
            'response_code' => $statusCode,
            'response_body' => $message,
            'type' => $service->type,
        ]);;
    }
}
