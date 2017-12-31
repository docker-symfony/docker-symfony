<?php
declare(strict_types=1);

namespace App;

class ServiceVersion
{
    /** @var string */
    private $version;
    /** @var string */
    private $name;
    /** @var bool */
    private $isDefault;

    public function __construct($version, $name, $isDefault = false)
    {
        $this->version = $version;
        $this->name = $name;
        $this->isDefault = $isDefault;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }
}
