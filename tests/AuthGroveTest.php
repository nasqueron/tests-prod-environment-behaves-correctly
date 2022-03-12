<?php

namespace Nasqueron\Infrastructure\ProductionTests;

use PHPUnit\Framework\TestCase;

class AuthGroveTest extends TestCase {
    use WithAssertHttp;

    public function testTLS () {
        $this->assertHttpResponseCode(301, 'http://login.nasqueron.org', 'Webserver should be configured to redirect http to https.');
        $this->assertHttpResponseCode(200, 'https://login.nasqueron.org/auth/login', "Auth Grove HTTPS login page isn't reachable.");
    }

    public function testAlive () {
        $url = 'https://login.nasqueron.org/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    public function testHomepage () {
        $url = 'https://login.nasqueron.org';
        $this->assertHttpResponseCode(302, $url, '/ should redirect to login page');

        $content = file_get_contents($url);
        $this->assertStringContainsString('https://login.nasqueron.org/auth/', $content);
    }

    public function testNotExisting () {
        $this->assertHttpResponseCode(404, 'https://login.nasqueron.org/notexisting', 'A 404 code were expected for a not existing page.');
    }
}
