<?php

namespace Nasqueron\Infrastructure\ProductionTests;

use PHPUnit\Framework\TestCase;

trait WithAssertHttp {
	/**
	 * Asserts the HTTP response code of an URL matches the expected code
	 */
	private function assertHttpResponseCode (int $expectedCode, string $url, string $comment = '') : void {
		$actualCode = $this->getHttpResponseCode($url);
		$this->assertEquals($expectedCode, $actualCode, $comment);
	}

	/**
	 * Gets the HTTP response code of the specified URL
	 */
	private function getHttpResponseCode (string $url) : int {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Nasqueron-Ops-Tests");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $code;
	}
}
