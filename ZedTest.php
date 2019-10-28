<?php

require_once 'traits/assertHttp.php';

class ZedTest extends PHPUnit\Framework\TestCase {
    use assertHttp;

    public function testAlive () {
        $url = 'https://hypership.space/';
        $this->assertHttpResponseCode(200, $url);
    }

    public function testContentRootIsForbidden () {
        $url = 'https://hypership.space/content/';
        $this->assertHttpResponseCode(403, $url);
    }

    public function testContent () {
        $url = 'https://hypership.space/content/scenes/B00002.png';
        $this->assertHttpResponseCode(200, $url);
    }
}
