<?php
declare(strict_types = 1);

namespace DockerSymfony\Builder;

use DockerSymfony\ComposeService;

class ApplicationBuilder
{
    /** @var string */
    private $name;
    /** @var  DockerComposeBuilder */
    private $dockerComposeBuilder;
    /** @var DockerfileBuilder */
    private $dockerfileBuilder;
    /** @var ComposeService[] */
    private $services = [];
    /** @var array */
    private $localFiles = [];
    /** @var array */
    private $dockerfileCommands = [];

    public function __construct(string $name, DockerComposeBuilder $dockerComposeBuilder, DockerfileBuilder $dockerfileBuilder)
    {
        $this->name = $name;
        $this->dockerComposeBuilder = $dockerComposeBuilder;
        $this->dockerfileBuilder = $dockerfileBuilder;
    }

    public function addService(ComposeService $service)
    {
        $this->services[$service->getName()] = $service;
        return $this;
    }

    public function addDockerfileCommand($serviceName, $command)
    {
        $this->dockerfileCommands[$serviceName][] = $command;
        return $this;
    }

    public function addLocalFile($path, $content)
    {
        $this->localFiles[$path] = $content;
        return $this;
    }

    public function generateFiles()
    {
        $services = array_map(function (ComposeService $thisService) {
            return clone $thisService;
        }, $this->services);

        $services = array_map([$this, 'setCustomImageOnDockerfile'], $services);

        $files = $this->localFiles;
        $files['docker-compose.yml'] = $this->dockerComposeBuilder->build($services);
        $files = array_merge($files, $this->generateDockerfiles());
        return $files;
    }

    private function generateDockerfiles()
    {
        $files = [];
        foreach ($this->dockerfileCommands as $service => $commands) {
            $filename = sprintf('Dockerfile_%s', $service);
            $commands[] = '';
            $files[$filename] = $this->dockerfileBuilder->build($this->services[$service], $commands);
        }
        return $files;
    }

    private function setCustomImageOnDockerfile(ComposeService $service)
    {
        if (!empty($this->dockerfileCommands[$service->getName()])) {
            $service->setImage(sprintf('%s-%s', $this->name, $service->getImage()));
        }

        return $service;
    }
}
