<?php

namespace Nasqueron\Infrastructure\ProductionTests;

use PHPUnit\Framework\TestCase;

class EtherpadTest extends TestCase {
    use WithAssertHttp;

    public function testEtherpadIsLive () {
        $this->assertHttpResponseCode(301, 'http://pad.nasqueron.org/', "Etherpad isn't redirected on HTTP.");
        $this->assertHttpResponseCode(200, 'https://pad.nasqueron.org/', "Etherpad looks down.");
        $this->assertHttpResponseCode(200, 'https://pad.wolfplex.be', "Etherpad doesn't reply to pad.wolfplex.be vhost.");
        $this->assertHttpResponseCode(404, 'https://pad.nasqueron.org/notexisting', 'A 404 code were expected for a not existing Etherpad page.');
    }

    public function testDeprecatedPluginAreNotInstalled () {
        $this->assertHttpResponseCode(404, 'https://pad.nasqueron.org/metrics', "ep_ether-o-meter plugin doesn't seem installed.");
    }

    public function testWolfplexApiWorks () {
        //Reported by philectro - 09:42 < philectro> hey tous les pad ont disparu :o

        $url = "https://api.wolfplex.org/pads/";
        $this->assertHttpResponseCode(200, $url);

        $stringOnlyAvailableWhenApiWorks = '","'; // pads titles separator
        $currentContent = file_get_contents($url);
        $this->assertStringContainsString($stringOnlyAvailableWhenApiWorks, $currentContent, "On Ysul, /home/wolfplex.org/logs/api.log could help. But more probably, you reinstalled the Etherpad container without restoring the API key. Move the former APIKEY.txt file to /opt/etherpad-lite or, if lost, update Wolfplex API credentials with the new API key.");
    }
}
