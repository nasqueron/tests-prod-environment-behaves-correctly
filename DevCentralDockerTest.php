<?php

require_once 'utils/DockerContainer.php';

class DevCentralDockerTest extends PHPUnit\Framework\TestCase {
	private $container;

	const DOCKER_CONTAINER = 'devcentral';

	protected function setUp () {
		if (!getenv('DOCKER_ACCESS')) {
			$this->markTestSkipped("No access to Docker engine.");
		}

		$this->container = new DockerContainer(getenv('DOCKER_HOST'), self::DOCKER_CONTAINER);
	}

	public function testInitialized () {
		$file = $this->container->exec("ls /opt/phabricator/.initialized");

		$this->assertSame(
			"/opt/phabricator/.initialized", $file,
			".initialized file is missing: that could mean the whole /usr/local/bin/setup-phabricator didn't run."
		);
	}

	public function testProcesses () {
		$processes = $this->container->exec("ps auxw");

		$expectedProcesses = [
			'nginx: master process',
			'nginx: worker process',
			'php-fpm: master process',
			'phd-daemon',
		];

		foreach ($expectedProcesses as $expectedProcess) {
			$this->assertContains($expectedProcess, $processes, "The process $expectedProcess isn't currently launched.");
		}
	}

	public function testPhabricatorDaemons () {
		$daemons = $this->container->exec("/opt/phabricator/bin/phd status");

		$expectedDaemons = [
			'PhabricatorRepositoryPullLocalDaemon',
			'PhabricatorTaskmasterDaemon',
		];

		foreach ($expectedDaemons as $expectedDaemon) {
			$this->assertContains($expectedDaemon, $daemons, "The daemon $expectedDaemon isn't currently launched.");
		}
	}
}
