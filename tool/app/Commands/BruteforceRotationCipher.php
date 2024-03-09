<?php

namespace App\Commands;

use App\Actions\Files\FilterWordlists;
use App\Actions\Runes\RunicRotationCipher;
use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use App\Actions\Strings\GeneratePermutation;
use App\Actions\Strings\RotationCipher;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforceRotationCipher extends Command
{
    protected $signature = 'app:bruteforce-rotation-cipher {sentence?} {--runic-shift}';

    protected $description = 'Takes runic sentence to bruteforce ROT# ciphers forwards and backwards.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $isRunic = (bool) $this->option('runic-shift');

        $folder = app_path('../../wordlists');
        $dictionaryWords = FilterWordlists::handle($folder, 2);

        $normalTranslation = TranslateSentenceAction::translate($sentence);
        $reversedTranslation = TranslateSentenceAction::translate($sentence, true);

        // Obtain our translated runic sentence both forwards and backwards.
        foreach ([$normalTranslation, $reversedTranslation] as $translation) {
            $this->info('Reversed?: '.($translation === $reversedTranslation ? 'Yes' : 'No').PHP_EOL);
            $permutations = GeneratePermutation::handle($translation);

            $tableHeader = [
                $translation,
                'Rotation',
                'Plaintext',
            ];
            $tableData = [];

            foreach ($permutations as $permutation) {
                foreach (range(0, 26) as $rotation) {
                    $plaintext = $isRunic
                        ? RunicRotationCipher::handle($permutation, $rotation)
                        : RotationCipher::handle($translation, $rotation);

                    // Inefficient, but we need to re-permute the string if runic shift was used.
                    if ($isRunic) {
                        $runicPermutations = GeneratePermutation::handle($plaintext);

                        foreach ($runicPermutations as $runicPermutation) {
                            if (Str::contains($runicPermutation, $dictionaryWords, ignoreCase: true)) {
                                $tableData[] = [
                                    'permutation' => $runicPermutation,
                                    'rotation' => $rotation,
                                    'plaintext' => $plaintext,
                                ];
                            }
                        }
                    } else {
                        if (Str::contains($plaintext, $dictionaryWords, ignoreCase: true)) {
                            $tableData[] = [
                                'permutation' => $permutation,
                                'rotation' => $rotation,
                                'plaintext' => $plaintext,
                            ];
                        }
                    }
                }

                // Since we shift the runic sentence, we only need to find one permutation that works.
                if ($isRunic) {
                    break;
                }
            }

            $this->table($tableHeader, $tableData);
        }

        return self::SUCCESS;
    }
}
