<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;

class RunicRotationCipher
{
    public static function handle(string $sentence, int $rotation, bool $reversed = false): string
    {
        $runeCount = count(Rune::cases());
        $plaintext = '';

        // Shift the runes themselves. Round-tripping through English letters is lossy, as two adjacent
        // runes (ie O + E) cannot be told apart from a single digraph rune (ie OE).
        foreach (mb_str_split($sentence) as $character) {
            $rune = Rune::tryFrom($character);

            // Anything that isn't a rune (spaces, numbers, punctuation) is preserved.
            if (! $rune) {
                $plaintext .= $character;

                continue;
            }

            $runicIndex = $reversed ? $rune->toReversedNumericPosition() : $rune->toNumericPosition();

            // Double modulo so negative rotations wrap around instead of going out of range.
            $shiftedIndex = (($runicIndex + $rotation) % $runeCount + $runeCount) % $runeCount;
            $plaintext .= Rune::tryFromIndex($shiftedIndex)->toSingleLetter();
        }

        return $plaintext;
    }
}
