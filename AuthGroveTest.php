<?php

require_once 'traits/assertHttp.php';

class AuthGroveTest extends PHPUnit\Framework\TestCase {
    use assertHttp;

    public function testRedirections () {
        $this->assertHttpResponseCode(301, 'http://login.nasqueron.org', 'Webserver should be configured to redirect http to https.');
        $this->assertHttpResponseCode(302, 'https://login.nasqueron.org', '/ should redirect to login page');
        $this->assertHttpResponseCode(404, 'https://login.nasqueron.org/notexisting', 'A 404 code were expected for a not existing page.');
    }

    public function testSSL () {
        $this->assertHttpResponseCode(200, 'https://login.nasqueron.org/auth/login', "Auth Grove HTTPS login page isn't reachable.");
    }

    public function testAlive () {
        $url = 'https://login.nasqueron.org/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    public function testHomepage () {
        $content = file_get_contents('https://login.nasqueron.org');
        $this->assertContains('https://login.nasqueron.org/auth/', $content);
    }
}
