<?php
declare(strict_types=1);

namespace DockerSymfony\Builder;

use DockerSymfony\ComposeService;

class DockerfileBuilder
{
    public function build(ComposeService $service, array $extraCommands = [])
    {
        $commands = [
            sprintf('FROM %s', $service->getImage())
        ];
        if (!empty($extraCommands)) {
            $commands = array_merge($commands, [''], $extraCommands);
        }

        return implode(PHP_EOL, $commands);
    }
}
