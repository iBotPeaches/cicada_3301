<?php

namespace App\Commands;

use App\Actions\Ciphers\GenerateTranspositionCipherMatrix;
use App\Actions\Strings\GeneratePossibleColumnKeyLengths;
use LaravelZero\Framework\Commands\Command;

class BruteforceColumnKey extends Command
{
    protected $signature = 'app:bruteforce-column-key {sentence?}';

    protected $description = 'Bruteforce a column key from a columnar transposition cipher.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to bruteforce');
        $singleWord = str_replace(' ', '', $sentence);

        $this->output->write('Sentence: '.$singleWord.PHP_EOL);
        $possibleKeyLengths = GeneratePossibleColumnKeyLengths::handle($singleWord);
        foreach ($possibleKeyLengths as $possibleKeyLength) {
            // Break the sentence into a matrix of the possible key length.
            $transpositionMatrix = GenerateTranspositionCipherMatrix::handle($singleWord, $possibleKeyLength);

            // Iterate all possible key permutations of that length, looking for English wordlists.
            $this->output->write('Possible key length: '.$possibleKeyLength.PHP_EOL);
        }

        return self::SUCCESS;
    }
}
