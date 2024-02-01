<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;
use Illuminate\Support\Str;
use UnexpectedValueException;

class GenerateRunesFromEnglish
{
    public static function handle(string $sentence): array
    {
        $pattern = '/(TH|EO|AE|NG|ING|IA|IO|EA|.)/';

        $array = preg_split($pattern, Str::upper($sentence), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $runes = [];

        foreach ($array as $letter) {
            $runicEnum = Rune::tryFromEnglish($letter);
            if (! $runicEnum) {
                throw new UnexpectedValueException("Could not find a rune for the letter: $letter");
            }
            $runes[] = $runicEnum;
        }

        return $runes;
    }
}
