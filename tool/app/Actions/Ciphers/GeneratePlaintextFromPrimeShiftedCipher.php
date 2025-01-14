<?php

declare(strict_types=1);

namespace App\Actions\Ciphers;

use App\Enums\Rune;

class GeneratePlaintextFromPrimeShiftedCipher
{
    public static function handle(array $sentence, int $shift = 0): string
    {
        $plainText = '';

        foreach ($sentence as $letter) {
            // If we have a Rune object - we need to prime shift it (+ optional shift)
            if (is_a($letter, Rune::class)) {
                // TODO
            } else {
                $plainText .= $letter;
            }
        }


        return $plainText;
    }
}
