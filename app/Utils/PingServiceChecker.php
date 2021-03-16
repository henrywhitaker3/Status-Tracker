<?php

namespace App\Utils;

use App\Actions\ServiceCheckFailedAction;
use App\Actions\ServiceCheckSucceededAction;
use App\Exceptions\ServiceCheckFailedException;
use App\Interfaces\ServiceCheckerInterface;
use App\Models\Service;
use App\Models\ServiceCheck;
use App\Utils\Extensions\PingCommandWrapper;
use Exception;

class PingServiceChecker implements ServiceCheckerInterface
{
    private PingCommandWrapper $pingCommandWrapper;

    private int $timeout;

    public function __construct(PingCommandWrapper $pingCommandWrapper)
    {
        $this->pingCommandWrapper = $pingCommandWrapper;
        $this->timeout = config('monitor.timeout');
    }

    public function check(Service $service): ServiceCheck
    {
        try {
            $this->pingCommandWrapper->setHost($service->check_url);
            $ping = $this->pingCommandWrapper->ping();
            $body = json_encode($ping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            if ($ping->host_status !== 'Ok') {
                throw new ServiceCheckFailedException(
                    $body,
                    0
                );
            }

            return run(
                ServiceCheckSucceededAction::class,
                $service,
                200,
                $body
            );
        } catch (Exception $e) {
            return run(
                ServiceCheckFailedAction::class,
                $service,
                $e->getCode(),
                $e->getMessage(),
            );
        }
    }
}
