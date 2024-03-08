<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Actions\Strings\SplitStringToEnglishRunePairs;
use App\Enums\Rune;

class RunicRotationCipher
{
    public static function handle(string $sentence, int $rotation): string
    {
        $runeCount = count(Rune::cases());
        $plaintext = '';
        $pairs = SplitStringToEnglishRunePairs::handle($sentence);
        foreach ($pairs as $pair) {
            // We skip spaces or numbers as those don't exist in Gematria Primus
            if ($pair === ' ' || is_numeric($pair)) {
                $plaintext .= ' ';

                continue;
            }

            // Get the rune from the English letter
            $rune = Rune::tryFromEnglish($pair);
            $runicIndex = $rune->toNumericPosition();

            $shiftedIndex = ($runicIndex + $rotation) % $runeCount;
            $shiftedRune = Rune::tryFromIndex($shiftedIndex);

            if ($shiftedRune) {
                $plaintext .= $shiftedRune->toSingleLetter();
            }
        }

        return $plaintext;
    }
}
