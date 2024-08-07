<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;

class TranslateVigenere
{
    public static function translate(string $sentence, array $key, array $indexesToSkip = [], bool $reversed = false): string
    {
        /* @var array[]|Rune[] $key */
        $letters = '';
        $runicIndex = 0;
        $runningRunicIndex = 0;
        $staticRunes = Rune::cases();
        $countOfRunes = count($staticRunes);
        $method = $reversed ? 'toReversedNumericPosition' : 'toNumericPosition';
        $runes = preg_split('//u', $sentence, -1, PREG_SPLIT_NO_EMPTY);

        // Our key is an array of each rune. We need to use index of each key to determine how to resolve the rune.
        // For example - giving "d" we know that is 6
        foreach ($runes as $rune) {
            $runningRunicIndex++;

            if ($rune === ' ') {
                $letters .= ' ';

                continue;
            }

            // Numbers have been proven to not be shift`ed.
            if (is_numeric($rune)) {
                $letters .= $rune;

                continue;
            }

            // If we don't recognize rune, just output (ie dots)
            $runeEnum = Rune::tryFrom($rune);
            if (! $runeEnum) {
                continue;
            }

            // For some ciphers, we may want to skip shifting at random points.
            if (in_array($runningRunicIndex, $indexesToSkip)) {
                $letters .= $runeEnum->toSingleLetter();

                continue;
            }

            $cipherKey = $key[$runicIndex] ?? null;
            if (! $cipherKey) {
                throw new \UnexpectedValueException('Runic key is not long enough to translate the sentence.');
            }

            // Now take the rune we are on and find its implicit index (0-n) in the Gematria.
            // We can take the key and individual rune and add its implicit index to complete the cipher.
            $index = $runeEnum->$method() - $cipherKey->$method();

            // If we bleed into negatives - lets bring us back.
            $index = $index < 0 ? $index + $countOfRunes : $index;
            $enum = $staticRunes[$index];

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
