<?php

namespace App\Actions;

use App\Models\ServiceCheck;
use App\Models\Setting;
use Carbon\Carbon;
use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class DeleteOldChecksAction implements ActionInterface
{
    /**
     * Delete all checks older than the retention policy.
     *
     * @return mixed
     */
    public function run()
    {
        ServiceCheck::where(
            'created_at',
            '<',
            Carbon::now()->subDays(Setting::retrieve('Data retention', true))
        )->delete();
    }
}
