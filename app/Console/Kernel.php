<?php

namespace App\Console;

use App\Actions\DeleteOldChecksAction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \App\Console\CustomSchedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->action(DeleteOldChecksAction::class)->everyHour();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function defineConsoleSchedule()
    {
        $this->app->instance(
            'Illuminate\Console\Scheduling\Schedule',
            $schedule = new CustomSchedule()
        );

        $this->schedule($schedule);
    }
}
