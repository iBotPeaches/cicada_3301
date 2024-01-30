<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;

class TranslateVigenere
{
    public static function translate(string $sentence, array $key, bool $reversed = false): string
    {
        /* @var array[]|Rune[] $key */
        $letters = '';
        $runicIndex = 0;
        $staticRunes = Rune::cases();
        $method = $reversed ? 'toReversedNumericPosition' : 'toNumericPosition';
        $runes = preg_split('//u', $sentence, -1, PREG_SPLIT_NO_EMPTY);

        // Our key is an array of each rune. We need to use index of each key to determine how to resolve the rune.
        // For example - giving "D|d" we know that is 6 or 22 depending on which direction is being used.
        // So as we iterate through the runes we match that index up to the key - wrapping when needed.
        foreach ($runes as $rune) {
            if ($rune === ' ') {
                $letters .= ' ';

                continue;
            }

            $cipherKey = $key[$runicIndex];
            $enum = $staticRunes[$cipherKey->$method()];

            // We don't need to reverse the letter, because we reversed (if needed) the rune.
            $letters .= $enum->toSingleLetter();

            // Move our key index back to the start if we have reached the end. This is so we wrap around the word.
            $runicIndex++;
            if ($runicIndex >= count($key)) {
                $runicIndex = 0;
            }
        }

        return $letters;
    }
}
