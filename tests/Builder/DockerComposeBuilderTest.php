<?php

namespace Tests\Builder;

use DockerSymfony\Builder\DockerComposeBuilder;
use DockerSymfony\ComposeService;
use PHPUnit\Framework\TestCase;

class DockerComposeBuilderTest extends TestCase
{
    public function test_empty()
    {
        $generator = new DockerComposeBuilder();

        $this->assertEquals(file_get_contents(__DIR__ . '/expected/empty.yml'), $generator->generate());
    }

    public function test_version()
    {
        $generator = new DockerComposeBuilder();
        $generator->setVersion(1);
        $this->assertEquals(file_get_contents(__DIR__ . '/expected/version.yml'), $generator->generate());
    }

    public function test_service_image()
    {
        $generator = new DockerComposeBuilder();
        $service = new ComposeService();
        $service->setName('ubuntu')->setImage('ubuntu:xenial');
        $generator->addService($service);
        $this->assertEquals(file_get_contents(__DIR__ . '/expected/service.yml'), $generator->generate());
    }
}