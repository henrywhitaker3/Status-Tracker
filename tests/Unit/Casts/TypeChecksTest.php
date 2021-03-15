<?php

namespace Tests\Unit\Casts;

use App\Exceptions\InvalidCheckTypeException;
use App\Models\Service;
use PHPUnit\Framework\TestCase;

class TypeChecksTest extends TestCase
{
    /**
     * Test whether you can set type as http
     *
     * @return void
     */
    public function test_can_set_type_http()
    {
        $service = new Service();
        $type = $service->type = 'http';

        $this->assertEquals('http', $type);
    }

    /**
     * Test whether you can set type as ping
     *
     * @return void
     */
    public function test_can_set_type_ping()
    {
        $service = new Service();
        $type = $service->type = 'ping';

        $this->assertEquals('ping', $type);
    }

    /**
     * Test whether you can set type as random
     *
     * @return void
     */
    public function test_cannot_set_type_random()
    {
        $this->expectException(InvalidCheckTypeException::class);

        $service = new Service();
        $type = $service->type = 'random';
    }
}
