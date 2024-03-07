<?php

namespace App\Commands;

use App\Actions\Files\FilterWordlists;
use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use App\Actions\Strings\GeneratePermutation;
use App\Actions\Strings\RotationCipher;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforceRotationCipher extends Command
{
    protected $signature = 'app:bruteforce-rotation-cipher {sentence?}';

    protected $description = 'Takes runic sentence to bruteforce ROT# ciphers forwards and backwards.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');

        $folder = app_path('../../wordlists');
        $dictionaryWords = FilterWordlists::handle($folder, 3);

        $normalTranslation = TranslateSentenceAction::translate($sentence);
        $reversedTranslation = TranslateSentenceAction::translate($sentence, true);

        // Obtain our translated runic sentence both forwards and backwards.
        foreach ([$normalTranslation, $reversedTranslation] as $translation) {

            // Our permutation library is chunky, so break down the strings into all permutations of the letters.
            GeneratePermutation::reset();
            GeneratePermutation::handle($translation);
            $permutations = GeneratePermutation::$permutations;

            $tableHeader = [
                $translation,
                'Rotation',
                'Plaintext',
            ];
            $tableData = [];

            foreach ($permutations as $permutation) {
                foreach (range(1, 26) as $rotation) {
                    $plaintext = RotationCipher::handle($permutation, $rotation);

                    if (Str::contains($plaintext, $dictionaryWords, ignoreCase: true)) {
                        $tableData[] = [
                            'permutation' => $permutation,
                            'rotation' => $rotation,
                            'plaintext' => $plaintext,
                        ];
                    }
                }
            }

            $this->table($tableHeader, $tableData);
        }

        return self::SUCCESS;
    }
}
