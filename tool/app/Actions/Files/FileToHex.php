<?php

declare(strict_types=1);

namespace App\Actions\Files;

use Illuminate\Support\Facades\File;

class FileToHex
{
    public static function handle(string $file): string
    {
        return bin2hex(File::get($file));
    }
}
