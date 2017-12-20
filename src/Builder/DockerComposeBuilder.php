<?php
declare(strict_types=1);

namespace DockerSymfony\Builder;

use DockerSymfony\ComposeService;
use Symfony\Component\Yaml\Yaml;

class DockerComposeBuilder
{
    const VERSION = '3';

    private $version = self::VERSION;
    /** @var ComposeService[] */
    private $services = [];

    public function generate(): string
    {
        $compose = [
            'version' => $this->version,
            'services' => []
        ];

        $compose['services'] = $this->servicesAsArray();

        if (empty($compose['services'])) {
            unset($compose['services']);
        }

        return Yaml::dump($compose, 4, 4, Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE);
    }

    /**
     * @param string $version
     * @return DockerComposeBuilder
     */
    public function setVersion(string $version): DockerComposeBuilder
    {
        $this->version = $version;
        return $this;
    }

    public function addService(ComposeService $service)
    {
        $this->services[] = $service;
        return $this;
    }

    /**
     * @return array
     */
    private function servicesAsArray(): array
    {
        $services = [];
        foreach ($this->services as $service) {
            $services[$service->getName()] = [
                'image' => $service->getImage()
            ];
        }
        return $services;
    }
}
