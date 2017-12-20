<?php
declare(strict_types=1);

namespace App;


use DockerSymfony\Builder\DockerComposeBuilder;
use DockerSymfony\ComposeService;

class BuildSymfony
{
    /** @var DockerComposeBuilder */
    private $builder;

    /**
     * BuildSymfony constructor.
     * @param DockerComposeBuilder $builder
     */
    public function __construct(DockerComposeBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getComposeYaml($phpVersion)
    {
        $phpService = new ComposeService();
        $phpService->setImage('php:'.$phpVersion)->setName('php');

        $nginxService = new ComposeService();
        $nginxService->setImage('nginx:latest')->setName('nginx');
        $this->builder->addService($phpService)->addService($nginxService);

        return $this->builder->generate();
    }
}