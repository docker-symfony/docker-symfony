<?php
declare(strict_types=1);

namespace DockerSymfony\Builder;

use DockerSymfony\ComposeService;
use Symfony\Component\Yaml\Yaml;

class DockerComposeBuilder
{

    /**
     * @param ComposeService[] $services
     * @param string $version
     * @return string
     */
    public function build(array $services = [], $version = '3'): string
    {
        $compose = [
            'version' => $version,
            'services' => []
        ];

        $compose['services'] = $this->servicesAsArray($services);

        if (empty($compose['services'])) {
            unset($compose['services']);
        }

        return Yaml::dump($compose, 4, 4, Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE);
    }

    /**
     * @param ComposeService[] $services
     * @return array
     */
    private function servicesAsArray(array $services = []): array
    {
        $servicesArray = [];
        foreach ($services as $service) {
            $servicesArray[$service->getName()] = [
                'image' => $service->getImage()
            ];
        }
        return $servicesArray;
    }
}
