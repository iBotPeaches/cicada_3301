<?php

declare(strict_types=1);

namespace App\Actions\Files;

class FilterWordlists
{
    public static function handle(string $folder, int $letterLimit): array
    {
        $words = ParseWordlistsIntoArray::handle($folder);

        return array_filter($words, function ($word) use ($letterLimit) {
            return strlen($word) > $letterLimit;
        });
    }
}
