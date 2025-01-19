<?php

declare(strict_types=1);

namespace App\Actions\Ciphers;

use App\Actions\Number\GetNextPrime;
use App\Enums\Rune;
use Illuminate\Support\Collection;

class GeneratePlaintextFromPrimeShiftedCipher
{
    public static function handle(Collection $sentence, int $shift = 0, array $indexesToSkip = []): string
    {
        $countOfRunes = count(Rune::cases());
        $plainText = '';
        $prime = 1;

        // Loop through each character in the sentence and follow one of the following rules:
        // 1 - The character should be skipped (recorded via indexes) and preserved as is
        // 2 - The character is a rune and needs to be shifted by the prime number + an optional shift.
        // 3 - The character is a regular character and should be preserved as is
        foreach ($sentence as $index => $character) {
            if (in_array($index, $indexesToSkip)) {
                $plainText .= is_string($character) ? $character : $character->toSingleLetter();
            } elseif (is_a($character, Rune::class)) {
                $prime = GetNextPrime::handle($prime);
                $runicIndex = $character->toNumericPosition();

                // Take the index of the rune and shift it by (prime - shift) then mod it by the count of runes
                $shiftedIndex = ($runicIndex - ($prime - $shift)) % $countOfRunes;

                // If the shifted index is negative, we need to add the count of runes to "wraparound"
                $shiftedIndex = $shiftedIndex < 0 ? $shiftedIndex + $countOfRunes : $shiftedIndex;

                $shiftedRune = Rune::tryFromIndex($shiftedIndex);
                $plainText .= $shiftedRune->toSingleLetter();
            } else {
                $plainText .= $character;
            }
        }

        return $plainText;
    }
}
