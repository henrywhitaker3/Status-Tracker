<?php

namespace App\Utils;

use App\Actions\ServiceCheckFailedAction;
use App\Actions\ServiceCheckSucceededAction;
use App\Models\Service;
use App\Models\ServiceCheck;
use Exception;
use GuzzleHttp\Client as GuzzleClient;

class ServiceChecker
{
    private GuzzleClient $http;

    private int $timeout;

    public function __construct(GuzzleClient $httpClient)
    {
        $this->http = $httpClient;
        $this->timeout = config('monitor.timeout');
    }

    public function check(Service $service): ServiceCheck
    {
        try {
            $response = $this->http->get(
                $service->check_url,
                [
                    'connect_timeout' => $this->timeout,
                    'timeout' => $this->timeout,
                ]
            );

            return run(
                ServiceCheckSucceededAction::class,
                $service,
                $response->getStatusCode(),
                $response->getBody()->getContents()
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
