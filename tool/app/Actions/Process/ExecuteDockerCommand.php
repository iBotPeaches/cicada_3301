<?php

declare(strict_types=1);

namespace App\Actions\Process;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class ExecuteDockerCommand
{
    public static function handle(string $containerId, string $command): ?string
    {
        $result = Process::run('docker exec '.$containerId.' '.$command);

        if ($result->exitCode() !== 0) {
            return null;
        }

        return Str::trim($result->output());
    }
}
