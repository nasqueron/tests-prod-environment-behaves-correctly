<?php

require_once 'traits/assertHttp.php';

class TommyTest extends PHPUnit\Framework\TestCase {
    use assertHttp;

    /**
     * @dataProvider provideTommyInstances
     */
    public function testIsLive (string $url) {
        $this->assertHttpResponseCode(200, $url, 'Tommy looks down.');
        $this->assertHttpResponseCode(404, $url . '/notexisting', 'A 404 code were expected for a not existing page.');
    }

    /**
     * @dataProvider provideTommyInstances
     */
    public function testAlive (string $url) {
        $url = $url . '/status';
        $this->assertHttpResponseCode(200, $url);
        $this->assertSame('ALIVE', file_get_contents($url));
    }

    /**
     * @dataProvider provideTommyInstances
     */
    public function testDashboard (string $url, string $instance) {
        $content = file_get_contents($url . '');
        $this->assertContains($instance . '/job/', $content);
    }

    ///
    /// Data providers
    ///

    public function provideTommyInstances () : iterable {
        yield ["https://builds.nasqueron.org", "ci.nasqueron.org"];
        yield ["https://infra.nasqueron.org/cd/dashboard", "cd.nasqueron.org"];
    }

}
