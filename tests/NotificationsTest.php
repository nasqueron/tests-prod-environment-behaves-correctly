<?php

namespace Nasqueron\Infrastructure\ProductionTests;

use PHPUnit\Framework\TestCase;

class NotificationsTest extends TestCase {
    use WithAssertHttp;

    ///
    /// Alive tests
    ///

    public function testIsLive () {
        $this->assertHttpResponseCode(200, 'http://notifications.nasqueron.org', 'Notifications center looks down.');
        $this->assertHttpResponseCode(404, 'http://notifications.nasqueron.org/notexisting', 'A 404 code were expected for a not existing page.');
    }

    public function testSSL () {
        $this->assertHttpResponseCode(200, 'https://notifications.nasqueron.org/', "Notifications center HTTPS issue.");
    }

    public function testAlive () {
        $url = 'http://notifications.nasqueron.org/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    ///
    /// Config tests
    ///

    public function testGates () {
        $this->assertHttpResponseCode(200, 'http://notifications.nasqueron.org/gate/GitHub', 'Gate missing: check GitHub is declared');
        $this->assertHttpResponseCode(200, 'http://notifications.nasqueron.org/gate/Phabricator/Nasqueron', 'Gate missing: check DevCentral is declared in credentials.json');
    }

    public function testConfig () {
        $url = 'https://notifications.nasqueron.org/config';
        $this->assertHttpResponseCode(200, $url);
        $this->assertJsonStringEqualsJsonFile(
             __DIR__ . "/data/notifications.config.json",
            file_get_contents($url),
            "The Notifications Center configuration doesn't match the expected configuration hardcoded in this repository."
        );
    }
}
