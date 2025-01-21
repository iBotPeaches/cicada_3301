<?php

declare(strict_types=1);

namespace App\Actions\Files;

use Illuminate\Support\Facades\File;

class ParseWordlistsIntoArray
{
    public static function handle(string $folder): array
    {
        $words = [];
        $files = File::allFiles($folder);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'txt') {
                continue;
            }
            $words = array_merge($words, explode("\n", File::get($file->getPathname())));
        }
        asort($words);

        return array_unique(array_filter($words));
    }
}
