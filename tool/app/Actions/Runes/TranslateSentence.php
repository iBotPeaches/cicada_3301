<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;

class TranslateSentence
{
    public static function translate(string $sentence, bool $reverse = false): string
    {
        $letters = '';
        $method = $reverse ? 'toReversedSingleLetter' : 'toSingleLetter';

        $runes = preg_split('//u', $sentence, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($runes as $rune) {
            // Check for space
            if ($rune === ' ') {
                $letters .= ' ';

                continue;
            }

            $enum = Rune::tryFrom($rune);

            // Numbers have been proven to not be shift`ed.
            if (is_numeric($rune)) {
                $letters .= $rune;

                continue;
            }

            $letters .= $enum?->$method() ?? '[?]';
        }

        return $letters;
    }
}
