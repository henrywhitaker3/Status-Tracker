<?php

namespace App\Utils;

use App\Models\Service;
use App\Models\ServiceCheck;
use Exception;
use GuzzleHttp\Client as GuzzleClient;

class ServiceChecker
{
    private GuzzleClient $http;

    public function __construct(GuzzleClient $httpClient)
    {
        $this->http = $httpClient;
    }

    public function check(Service $service): ServiceCheck
    {
        try {
            $response = $this->http->get($service->check_url);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $up = true;
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $body = $e->getMessage();
            $up = false;
        }

        return $service->checks()->create([
            'up' => $up,
            'response_code' => $statusCode,
            'response_body' => $body,
        ]);
    }
}
