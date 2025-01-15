<?php

declare(strict_types=1);

namespace App\Actions\Ciphers;

use App\Actions\Number\StreamPrimes;
use App\Enums\Rune;
use Illuminate\Support\Collection;

class GeneratePlaintextFromPrimeShiftedCipher
{
    public static function handle(Collection $sentence, int $shift = 0): string
    {
        $countOfRunes = count(Rune::cases());
        $plainText = '';

        // Start streaming primes until we explicitly break - as it's an infinite loop
        foreach (StreamPrimes::handle() as $index => $prime) {
            // We know the sentence is implicitly indexed (0,1,2...) so we can use the iterator index to loop
            $character = $sentence->get($index);
            if (is_null($character)) {
                break;
            }

            // If we have a rune - we know we want to shift it by the prime + the shift
            // Otherwise we just append the character as is
            if (is_a($character, Rune::class)) {
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
