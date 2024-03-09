<?php

declare(strict_types=1);

namespace App\Actions\Ciphers;

class GenerateTranspositionCipherMatrix
{
    public static function handle(string $sentence, int $amountOfColumns): array
    {
        $sentenceLength = strlen($sentence);
        $matrix = [];
        $row = 0;
        $column = 0;

        for ($i = 0; $i < $sentenceLength; $i++) {
            $matrix[$row][$column] = $sentence[$i];
            $column++;

            if ($column === $amountOfColumns) {
                $column = 0;
                $row++;
            }
        }

        return $matrix;
    }
}
