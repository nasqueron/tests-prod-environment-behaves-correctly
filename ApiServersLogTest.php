<?php

require_once 'traits/assertHttp.php';

class ApiServersLogTest extends PHPUnit_Framework_TestCase {
    use assertHttp;

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
