<?php
declare(strict_types=1);

namespace Tests\Builder;

use DockerSymfony\Builder\DockerfileBuilder;
use DockerSymfony\ComposeService;
use PHPUnit\Framework\TestCase;

class DockerfileBuilderTest extends TestCase
{
    public function test_build()
    {
        $builder = new DockerfileBuilder();

        $service = new ComposeService('service', 'image');
        $dockerfile = $builder->build($service);

        $this->assertEquals(
            trim(file_get_contents(__DIR__ . '/expected/service.dockerfile')),
            $dockerfile
        );
    }

    public function test_build_extra_commands()
    {
        $builder = new DockerfileBuilder();

        $service = new ComposeService('service', 'image');
        $dockerfile = $builder->build($service, ['RUN do something']);

        $this->assertEquals(
            trim(file_get_contents(__DIR__ . '/expected/do-something.dockerfile')),
            $dockerfile
        );
    }
}
