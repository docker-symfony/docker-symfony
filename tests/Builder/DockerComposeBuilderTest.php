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

        $this->assertEquals(file_get_contents(__DIR__ . '/expected/empty.yml'), $generator->build());
    }

    public function test_version()
    {
        $generator = new DockerComposeBuilder();
        $this->assertEquals(
            file_get_contents(__DIR__ . '/expected/version.yml'),
            $generator->build([], '1')
        );
    }

    public function test_service_image()
    {
        $generator = new DockerComposeBuilder();
        $service = new ComposeService('ubuntu', 'ubuntu:xenial');
        $dockerCompose = $generator->build([$service]);
        $this->assertEquals(
            file_get_contents(__DIR__ . '/expected/service.yml'),
            $dockerCompose
        );
    }
}