<?php

require_once 'traits/assertHttp.php';

class TommyTest extends PHPUnit\Framework\TestCase {
    use assertHttp;

    public function testIsLive () {
        $this->assertHttpResponseCode(200, 'https://builds.nasqueron.org', 'Tommy looks down.');
        $this->assertHttpResponseCode(404, 'https://builds.nasqueron.org/notexisting', 'A 404 code were expected for a not existing page.');
    }

    public function testAlive () {
        $url = 'https://builds.nasqueron.org/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    public function testDashboard () {
        $content = file_get_contents('https://builds.nasqueron.org');
        $this->assertContains('ci.nasqueron.org/job/', $content);
    }
}
