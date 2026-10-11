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
            // Get the rune from the English letter. Anything without a rune (spaces, numbers, punctuation) is preserved.
            $rune = Rune::tryFromEnglish($pair);
            if (! $rune) {
                $plaintext .= $pair;

                continue;
            }

            // Double modulo so negative rotations wrap around instead of going out of range.
            $shiftedIndex = (($rune->toNumericPosition() + $rotation) % $runeCount + $runeCount) % $runeCount;
            $plaintext .= Rune::tryFromIndex($shiftedIndex)->toSingleLetter();
        }

        return $plaintext;
    }
}
