<?php
declare(strict_types=1);

namespace App;

use DockerSymfony\Builder\ApplicationBuilder;
use DockerSymfony\ComposeService;

class SymfonyBuilder
{
    /** @var ApplicationBuilder */
    private $applicationBuilder;

    /**
     * SymfonyBuilder constructor.
     * @param ApplicationBuilder $applicationBuilder
     */
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

    public function getSupportedServices()
    {
        return [
            'PHP' => [
                'versions' => [
                    '7.2' => 'php:fpm-7.2',
                    '7.1' => 'php:fpm-7.1',
                    '7.0' => 'php:fpm-7.0',
                    '5.6' => 'php:fpm-5.6',
                ]
            ],
            'Mysql' => [
                'versions' => [
                    '5.7' => 'mysql:5.7',
                    '5.6' => 'mysqk:5.6',
                ]
            ],
            'Web server' => [
                'Nginx' => [
                    'versions' => [
                        '1.13' => 'ngnix:1.13',
                        '1.12' => 'ngnix:1.12',
                        '1.11' => 'ngnix:1.11',
                        '1.10' => 'ngnix:1.10',
                    ]
                ],
                'Apache' => [
                    'versions' => [
                        '2.4' => 'httpd:2.4',
                        '2.2' => 'httpd:2.2'
                    ]
                ]
            ]
        ];
    }
}