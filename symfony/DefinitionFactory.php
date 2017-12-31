<?php
declare(strict_types=1);

namespace App;

use DockerSymfony\Builder\ApplicationBuilder;
use DockerSymfony\ComposeService;

class DefinitionFactory
{
    /** @var ApplicationBuilder */
    private $applicationBuilder;

    public function __construct(ApplicationBuilder $applicationBuilder)
    {
        $this->applicationBuilder = $applicationBuilder;
    }

    public function addService($name, $version)
    {
        $this->applicationBuilder->addService(new ComposeService($name, $version));
        return $this;
    }

    public function build()
    {
        return $this->applicationBuilder->generateFiles();
    }

    public function createSymfony()
    {
        $categories = ['php', 'mysql', 'web server'];
        $services = [
            $this->createPhpService(),
            $this->createMysqlService(),
            $this->createNginxService(),
            $this->createApacheService(),
        ];

        return new ApplicationDefinition($categories, $services);
    }


    private function createPhpService(): ServiceDefinition
    {
        return new ServiceDefinition(
            'php',
            [
                new ServiceVersion('php:fpm-7.2', '7.2', true),
                new ServiceVersion('php:fpm-7.1', '7.1'),
                new ServiceVersion('php:fpm-7.0', '7.0'),
                new ServiceVersion('php:fpm-5.6', '5.6'),
            ],
            ['php']
        );
    }

    private function createMysqlService(): ServiceDefinition
    {
        return new ServiceDefinition(
            'mysql',
            [
                new ServiceVersion('mysql:8', '8'),
                new ServiceVersion('mysql:5.7', '5.7', true),
                new ServiceVersion('mysql:5.6', '5.6'),
                new ServiceVersion('mysql:5.5', '5.5'),
            ],
            ['mysql']
        );
    }

    private function createNginxService()
    {
        return new ServiceDefinition(
            'nginx',
            [
                new ServiceVersion('nginx:1.13', '1.13', true),
                new ServiceVersion('nginx:1.12', '1.12'),
            ],
            ['web server']
        );
    }

    private function createApacheService()
    {
        return new ServiceDefinition(
            'httpd',
            [
                new ServiceVersion('httpd:2.4', '2.4', true),
                new ServiceVersion('httpd:2.2', '2.2'),
            ],
            ['web server']
        );
    }
}
