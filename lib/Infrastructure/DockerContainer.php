<?php

namespace Nasqueron\Infrastructure;

class DockerContainer {
    private $host;
    private $container;

    /**
     * Initializes a new instance of the DockerContainer class
     *
     * @param string $host hostname
     * @param string $container container name
     */
    public function __construct ($host, $container) {
        if (!self::isValidHostname($host)) {
            throw new ArgumentException("Invalid hostname.");
        }
        if (!self::isValidContainerName($container)) {
            throw new ArgumentException("Invalid container name.");
        }

        $this->host = $host;
        $this->container = $container;
    }

    /**
     * Determines if a hostname is valid
     */
    public static function isValidHostname ($host) : bool {
        return (bool)preg_match('/^[A-Za-z0-9\-\.]+$/', $host);
    }

    /**
     * Determines if a container name is valid
     */
    public static function isValidContainerName ($name) : bool {
        //Source: https://github.com/ajhager/docker/commit/f63cdf0260cf6287d28a589a79d3f947def6a569
        return (bool)preg_match('@^/?[a-zA-Z0-9_-]+$@', $name);
    }

    /**
     * Executes the specified command in the container
     *
     * @param string $command the command to run
     * @return string the command output
     */
    public function exec ($command) : string {
        $output = `ssh $this->host sudo docker exec $this->container $command`;
        return trim($output);
    }
}
