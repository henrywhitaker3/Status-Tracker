<?php

namespace Tests\Mocks;

use App\Utils\Extensions\PingCommandWrapper;
use Exception;

class MockPingCommandWrapper extends PingCommandWrapper
{
    private bool $passes;

    public function __construct(bool $passes)
    {
        $this->passes = $passes;
    }

    public function ping()
    {
        return $this->rerturnClass();
    }

    private function rerturnClass()
    {
        return (object) [
            'host_status' => $this->passes ? 'Ok' : 'Nope'
        ];
    }
}
