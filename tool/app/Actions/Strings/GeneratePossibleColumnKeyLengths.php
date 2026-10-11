<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class GeneratePossibleColumnKeyLengths
{
    public static function handle(string $sentence): array
    {
        $singleWord = str_replace(' ', '', $sentence);
        $wordLength = strlen($singleWord);
        $keyLengths = [];

        for ($possibleKeyLength = 1; $possibleKeyLength <= intdiv($wordLength, 2); $possibleKeyLength++) {
            if ($wordLength % $possibleKeyLength === 0) {
                $keyLengths[] = $possibleKeyLength;
            }
        }

        return $keyLengths;
    }
}
