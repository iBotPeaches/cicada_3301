<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Actions\Strings\SplitStringToEnglishRunePairs;
use App\Enums\Rune;
use UnexpectedValueException;

class GenerateRunesFromEnglish
{
    public static function handle(string $sentence): array
    {
        $array = SplitStringToEnglishRunePairs::handle($sentence);
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
