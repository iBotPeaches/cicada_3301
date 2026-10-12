<?php

namespace App\Commands;

use App\Actions\Files\FilterWordlists;
use App\Actions\Runes\RunicRotationCipher;
use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use App\Actions\Strings\GeneratePermutation;
use App\Actions\Strings\RotationCipher;
use App\Enums\Rune;
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

        // Gematria Primus has 29 runes, while the Latin alphabet has 26 letters.
        $rotations = $isRunic ? range(0, count(Rune::cases()) - 1) : range(0, 25);

        // Obtain our translated runic sentence both forwards and backwards.
        foreach (['No' => $normalTranslation, 'Yes' => $reversedTranslation] as $isReversed => $translation) {
            $this->info('Reversed?: '.$isReversed.PHP_EOL);
            $reversed = $isReversed === 'Yes';
            $permutations = GeneratePermutation::handle($translation);

            $tableHeader = [
                $translation,
                'Rotation',
                'Plaintext',
            ];
            $tableData = [];

            foreach ($permutations as $permutation) {
                foreach ($rotations as $rotation) {
                    $plaintext = $isRunic
                        ? RunicRotationCipher::handle($sentence, $rotation, $reversed)
                        : RotationCipher::handle($permutation, $rotation);

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

                // Since we shift the runes directly, the permutations of the translation don't matter.
                if ($isRunic) {
                    break;
                }
            }

            $this->table($tableHeader, $tableData);
        }

        return self::SUCCESS;
    }
}
