<?php

namespace App\Utils\Extensions;

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;
use App\Exceptions\HostNotSetException;

class PingCommandWrapper
{
    private ?PingCommandBuilder $pingCommandBuilder;

    private int $timeout;

    public function __construct($host = null)
    {
        $this->pingCommandBuilder = ($host !== null ? new PingCommandBuilder($host) : null);
        $this->timeout = config('monitor.timeout');
    }

    /**
     * Ping the service.
     *
     * @return bool|object
     * @throws HostNotSetException
     */
    public function ping()
    {
        if ($this->isPingCommandBuilderSet()) {
            $this->pingCommandBuilder->timeout($this->timeout);

            return (new Ping($this->pingCommandBuilder))->run();
        }

        return false;
    }

    /**
     * Update the host.
     *
     * @param string $host
     * @return void
     */
    public function setHost(string $host)
    {
        $this->pingCommandBuilder = new PingCommandBuilder($host);
    }

    /**
     * Determines if the PingCommandHelper is set and ready
     * to be used.
     *
     * @return bool
     * @throws HostNotSetException
     */
    private function isPingCommandBuilderSet()
    {
        if ($this->pingCommandBuilder === null) {
            throw new HostNotSetException('Host not set for PingCommandHelper');
        }

        return true;
    }
}
