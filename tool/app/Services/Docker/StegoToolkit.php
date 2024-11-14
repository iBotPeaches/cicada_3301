<?php

declare(strict_types=1);

namespace App\Services\Docker;

use App\Actions\Process\ExecuteDockerCommand;

class StegoToolkit
{
    public function __construct(public string $containerId)
    {
        if (! ExecuteDockerCommand::handle($this->containerId, '/bin/bash')) {
            throw new \Exception('Failed to start shell in container');
        }
    }
}
