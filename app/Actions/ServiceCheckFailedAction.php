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
    public function run(
        Service $service = null,
        int $statusCode = null,
        string $message = null
    ) {
        return $service->checks()->create([
            'up' => false,
            'response_code' => $statusCode,
            'response_body' => $message,
            'type' => $service->type,
        ]);;
    }
}
