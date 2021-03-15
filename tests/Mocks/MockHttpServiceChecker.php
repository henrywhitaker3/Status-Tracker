<?php

namespace Tests\Mocks;

use App\Actions\ServiceCheckFailedAction;
use App\Actions\ServiceCheckSucceededAction;
use App\Models\Service;
use App\Models\ServiceCheck;
use App\Utils\HttpServiceChecker;

class MockHttpServiceChecker extends HttpServiceChecker
{
    private bool $pass;

    public function __construct(bool $pass)
    {
        $this->setPass($pass);
    }

    public function check(Service $service): ServiceCheck
    {
        if ($this->pass) {
            return run(
                ServiceCheckSucceededAction::class,
                $service,
                200,
                'It passeed!',
            );
        }

        return run(
            ServiceCheckFailedAction::class,
            $service,
            0,
            'It didn\'t pass!',
        );
    }

    public function setPass(bool $pass)
    {
        $this->pass = $pass;
    }
}
