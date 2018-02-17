<?php

require_once 'traits/assertHttp.php';

/**
 * These tests ensure Apache has been recompiled with
 * the right options as long as SuEXEC is concerned.
 */
class YsulApacheTest extends PHPUnit\Framework\TestCase {
	use assertHttp;

	/**
	 * Apache server hostname to test
	 */
	const SERVER = 'ysul.nasqueron.org';

	/**
	 * Apache port
	 */
	const PORT = 3200;

    /**
     * @var string
     */
    protected $url;

    public function setUp () {
        $this->url = "http://" . self::SERVER . ":" . self::PORT . "/";
    }

	public function testApacheIsLive () {
		$this->assertHttpResponseCode(200, $this->url, "Apache looks down.");
	}

    public function testUserDirectoryWorks () {
        $url = $this->url . "~qa/status.html";
        $this->assertHttpResponseCode(200, $url, "Apache doesn't serve user directories.");
    }

    public function testUserDirectoryChmod () {
        $url = $this->url . "~qa/";
        $this->assertHttpResponseCode(200, $url, "Apache doesn't autoindex user directories.");

        $url = $this->url . "~qa/noautoindex/";
        $this->assertHttpResponseCode(403, $url, "Apache should return a 403 for user directories chmoded 711.");
    }

	public function testSuEXECHasBeenInstalled () {
		// Reported by amj on T823, see also T508 and T517.

        $url = $this->url . "~qa/test.cgi";
		$this->assertHttpResponseCode(200, $url, "SuEXEC isn't installed or not configured to allow public_html CGI scripts.");

        $url = $this->url . "~qa/test.php";
		$this->assertHttpResponseCode(200, $url, "SuEXEC should be patched to invoke php interpreter when the extension is .php.");
	}
}
