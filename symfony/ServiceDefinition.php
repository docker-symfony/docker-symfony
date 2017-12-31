<?php
declare(strict_types=1);

namespace App;

class ServiceDefinition
{
    /** @var string */
    private $name;
    /** @var ServiceVersion[] */
    private $versions;
    /** @var array */
    private $categories;

    public function __construct($name, array $versions, array $categories)
    {
        $this->name = $name;
        $this->versions = $versions;
        $this->categories = $categories;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ServiceVersion[]
     */
    public function getVersions(): array
    {
        return $this->versions;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}
