<?php

declare(strict_types=1);

namespace App\Actions\Ciphers;

class GeneratePlaintextFromTranspositionCipher
{
    public static function handle(array $matrix, array $keyIndices): string
    {
        $plainText = '';

        foreach ($matrix as $row) {
            foreach ($keyIndices as $keyIndex) {
                $plainText .= $row[$keyIndex];
            }
        }

        return $plainText;
    }
}
