<?php
declare(strict_types = 1);

namespace Tests\Builder;

use DockerSymfony\Builder\ApplicationBuilder;
use DockerSymfony\Builder\DockerComposeBuilder;
use DockerSymfony\Builder\DockerfileBuilder;
use DockerSymfony\ComposeService;
use PHPUnit\Framework\TestCase;

class ApplicationBuilderTest extends TestCase
{
    public function test_generates_docker_compose()
    {
        $application = new ApplicationBuilder('app', $builder = new DockerComposeBuilder(), new DockerfileBuilder());
        $this->assertEquals(['docker-compose.yml' => $builder->build()], $application->generateFiles());
    }

    public function test_local_file()
    {
        $application = new ApplicationBuilder('app', new DockerComposeBuilder(), new DockerfileBuilder());
        $application->addLocalFile('test/test.txt', 'test content');

        $this->assertArraySubset(
            [
                'test/test.txt' => 'test content',
            ],
            $application->generateFiles()
        );
    }

    public function test_add_dockerfile_command()
    {
        $application = new ApplicationBuilder('app', $builder = new DockerComposeBuilder(), new DockerfileBuilder());
        $application->addService(new ComposeService('service', 'image'));
        $application->addDockerfileCommand('service', 'RUN do something');

        $this->assertArraySubset(
            [
                'Dockerfile_service' => file_get_contents(__DIR__ . '/expected/do-something.dockerfile'),
            ],
            $application->generateFiles()
        );
    }

    public function test_change_image_with_dockerfile_command()
    {
        $application = new ApplicationBuilder('app', $builder = new DockerComposeBuilder(), new DockerfileBuilder());
        $application->addService(new ComposeService('service', 'image'));
        $application->addDockerfileCommand('service', 'RUN do something');

        $this->assertArraySubset(
            [
                'docker-compose.yml' => file_get_contents(__DIR__ . '/expected/do-something.yml'),
            ],
            $application->generateFiles()
        );
    }
}