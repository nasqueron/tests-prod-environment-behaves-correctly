<?php

namespace Nasqueron\Infrastructure\ProductionTests;

use PHPUnit\Framework\TestCase;

class ApiServersLogTest extends TestCase {
    use WithAssertHttp;

    public function testAlive () {
        $url = 'https://api.nasqueron.org/servers-log/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    public function testPutEntryPointWithGetRequestReturns405 () {
        $url = 'https://api.nasqueron.org/servers-log';
        $this->assertHttpResponseCode(405, $url);
    }
}
