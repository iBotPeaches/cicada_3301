<?php

namespace App\Commands;

use App\Actions\Arrays\GeneratePermutation;
use App\Actions\Ciphers\GeneratePlaintextFromTranspositionCipher;
use App\Actions\Ciphers\GenerateTranspositionCipherMatrix;
use App\Actions\Files\FilterWordlists;
use App\Actions\Strings\GeneratePossibleColumnKeyLengths;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforceColumnKey extends Command
{
    protected $signature = 'app:bruteforce-column-key {sentence?} {--max-results=2}';

    protected $description = 'Bruteforce a column key from a columnar transposition cipher.';

    public function handle(): int
    {
        $maxResults = (int) $this->option('max-results');
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to bruteforce');
        $singleWord = str_replace(' ', '', $sentence);

        $folder = app_path('../../wordlists');
        $dictionaryWords = FilterWordlists::handle($folder, 5);
        $detectedPhrases = 0;

        $this->output->write('Sentence: '.$singleWord.PHP_EOL);
        $possibleKeyLengths = GeneratePossibleColumnKeyLengths::handle($singleWord);
        foreach ($possibleKeyLengths as $possibleKeyLength) {
            $tableHeader = [
                sprintf('Key (%d)', $possibleKeyLength),
                'Plaintext',
            ];
            $tableData = [];

            // Skip 1 or 2 matrix sizes as those are too small to be useful.
            if ($possibleKeyLength < 3) {
                continue;
            }

            // Break the sentence into a matrix of the possible key length.
            $transpositionMatrix = GenerateTranspositionCipherMatrix::handle($singleWord, $possibleKeyLength);

            // Our starting key will be in form of 0...n
            $startingKey = range(0, $possibleKeyLength - 1);

            // Iterate all possible key permutations of that length, looking for English wordlists.
            $permutations = GeneratePermutation::handle($startingKey);
            foreach ($permutations as $permutation) {
                $plaintext = GeneratePlaintextFromTranspositionCipher::handle($transpositionMatrix, $permutation);

                if (Str::contains($plaintext, $dictionaryWords, ignoreCase: true)) {
                    $key = implode('', $permutation);
                    $tableData[$key] = [
                        'key' => $key,
                        'plaintext' => $plaintext,
                    ];
                    $detectedPhrases++;
                }
            }

            $this->table($tableHeader, $tableData);

            if ($detectedPhrases >= $maxResults) {
                break;
            }
        }

        return self::SUCCESS;
    }
}
