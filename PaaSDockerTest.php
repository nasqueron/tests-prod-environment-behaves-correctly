<?php

require_once 'traits/assertHttp.php';
require_once 'utils/OperationsConfiguration.php';

use Nasqueron\Infrastructure\OperationsConfiguration;

class PaaSDockerTest extends PHPUnit\Framework\TestCase {

    use assertHttp;

    /**
     * @dataProvider provideDockerDomains
     *
     * @param string $domain A domain declared in the PaaS Docker configuration
     *                       as an HTTP upstream block for a Docker container
     */
    public function test502Pages (string $domain) : void {
        $url = "https://$domain/502.html";

        $this->assertHttpResponseCode(200, $url, "A 502 page is missing for $domain");
    }

    public function provideDockerDomains () : iterable {
        $domains = OperationsConfiguration::getDockerDomains();

        foreach ($domains as $domain) {
            yield [$domain];
        }
    }

}
