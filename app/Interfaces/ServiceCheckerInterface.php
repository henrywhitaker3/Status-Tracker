<?php

namespace App\Interfaces;

use App\Models\Service;
use App\Models\ServiceCheck;

interface ServiceCheckerInterface
{
    /**
     * Run a serrvice status check
     *
     * @param Service $service
     * @return ServiceCheck
     */
    public function check(Service $service): ServiceCheck;
}
