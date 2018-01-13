<?php
declare(strict_types = 1);

namespace App;

class ApplicationDefinition
{
    /** @var array */
    private $categories;
    /** @var ServiceDefinition[] */
    private $services;

    public function __construct(array $categories, array $services)
    {
        $this->categories = $categories;
        $this->services = $services;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @return ServiceDefinition[]
     */
    public function getServicesByCategory($category): array
    {
        return array_filter(
            $this->services,
            function (ServiceDefinition $service) use ($category) {
                return in_array($category, $service->getCategories());
            }
        );
    }
}
