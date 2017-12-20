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
    /** @var string */
    private $name;
    /** @var string */
    private $image;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ComposeService
     */
    public function setName(string $name): ComposeService
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return ComposeService
     */
    public function setImage(string $image): ComposeService
    {
        $this->image = $image;
        return $this;
    }
}