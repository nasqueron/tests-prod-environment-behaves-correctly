<?php

namespace Nasqueron\Infrastructure;

class OperationsConfiguration {

    const PILLAR_BASE = "https://raw.githubusercontent.com/nasqueron/operations/master/pillar/";

    public static function getDockerDomains () : array {
        $domains = [];

        $pillar = self::readPillarFile("paas/docker.sls");
        foreach ($pillar['docker_containers'] as $instances) {
            foreach ($instances as $containers) {
                foreach ($containers as $instance) {
                    if (isset($instance['host'])) {
                        $domains[] = $instance['host'];
                    }
                }
            }
        }

        return $domains;
    }

    public static function readPillarFile ($path) : iterable {
        $url = self::PILLAR_BASE . $path;
        $yaml = file_get_contents($url);

        return yaml_parse($yaml);
    }

}
