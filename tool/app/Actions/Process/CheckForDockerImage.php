<?php

declare(strict_types=1);

namespace App\Actions\Process;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class CheckForDockerImage
{
    public static function handle(string $imageName): ?string
    {
        $result = Process::run('docker images -q '.$imageName.' 2> /dev/null');

        if ($result->exitCode() !== 0) {
            return null;
        }

        return Str::trim($result->output());
    }
}
