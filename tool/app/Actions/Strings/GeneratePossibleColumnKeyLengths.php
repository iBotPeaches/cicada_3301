<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class GeneratePossibleColumnKeyLengths
{
    public static function handle(string $sentence): array
    {
        $singleWord = str_replace(' ', '', $sentence);
        $wordLength = strlen($singleWord);
        $possibleKeyLengths = range(1, ($wordLength / 2));
        $keyLengths = [];

        foreach ($possibleKeyLengths as $possibleKeyLength) {
            if ($wordLength % $possibleKeyLength === 0) {
                $keyLengths[] = $possibleKeyLength;
            }
        }

        return array_unique($keyLengths);
    }
}
