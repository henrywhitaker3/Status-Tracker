<?php

namespace App\Console;

use Henrywhitaker3\LaravelActions\Interfaces\ActionInterface;

class CustomSchedule extends \Illuminate\Console\Scheduling\Schedule
{
    /**
     * Runs an action as a schedule callback
     *
     * @param ActionInterface|string $action
     * @param mixed ...$args
     * @return \Illuminate\Console\Scheduling\CallbackEvent
     */
    public function action($action, ...$args)
    {
        return $this->call(function () use ($action, $args) {
            return run($action, ...$args);
        });
    }
}
