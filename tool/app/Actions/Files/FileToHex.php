<?php

declare(strict_types=1);

namespace App\Actions\Files;

use Illuminate\Support\Facades\File;

class FileToHex
{
    public static function handle(string $file, int $offset = 0, ?int $length = null): string
    {
        // Only read the requested bytes, as some files (ie 560.13) are 100MB+ and double in size as hex.
        if ($offset === 0 && $length === null) {
            return bin2hex(File::get($file));
        }

        return bin2hex((string) file_get_contents($file, false, null, $offset, $length));
    }
}
