<?php

namespace App\Console\Commands;

use App\Actions\DispatchServiceChecks;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ServiceCheckDaemon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the service check daemon';

    private int $interval;

    private bool $run;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->interval = config('monitor.interval');
        $this->run = true;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output('info', __('dispatcher.start', ['interval' => $this->interval]));

        pcntl_async_signals(true);

        pcntl_signal(SIGINT, [$this, 'shutdown']);
        pcntl_signal(SIGTERM, [$this, 'shutdown']);

        while ($this->run) {
            $count = run(DispatchServiceChecks::class);

            $this->output('info', __('dispatcher.dispatched', ['count' => $count]));

            sleep($this->interval);
        }
    }

    public function output(string $type, string $content)
    {
        $this->{$type}(
            Carbon::now()->toDateTimeLocalString() . ' - ' . $content
        );
    }

    private function shutdown()
    {
        $this->output('info', __('dispatcher.die'));
        $this->run = false;
    }
}
