<?php

namespace App\Actions;

use App\Models\Service;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class ServiceCheckSucceededAction implements ActionInterface
{
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
        if ($service->status !== true) {
            $service->status = true;
            $service->status_changed_at = Carbon::now();
            $service->save();
        }

        return $service->checks()->create([
            'up' => true,
            'response_code' => $statusCode,
            'response_body' => $message,
            'type' => $service->type,
        ]);
    }
}
