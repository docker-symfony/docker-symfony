<?php
declare(strict_types=1);

namespace DockerSymfony;

/**
 * Class ComposeService
 * @package DockerSymfony
 * @see https://docs.docker.com/compose/compose-file
 */
class ComposeService
{
    const DEFAULT_IMAGE = 'scratch';
    /** @var string */
    private $name;
    /** @var string */
    private $image = self::DEFAULT_IMAGE;

    /**
     * ComposeService constructor.
     * @param string $name
     * @param string $image
     */
    public function __construct($name, $image = null)
    {
        $this->name = $name;
        $image && $this->image = $image;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
