<?php

namespace App\Commands;

use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use App\Actions\Strings\GeneratePermutation;
use LaravelZero\Framework\Commands\Command;

class BruteforceRotationCipher extends Command
{
    protected $signature = 'app:bruteforce-rotation-cipher {sentence?}';

    protected $description = 'Takes runic sentence to bruteforce ROT# ciphers forwards and backwards.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');

        // TODO Port the ColumnKey wordlist loading into action for re-use

        $normalTranslation = TranslateSentenceAction::translate($sentence);
        $reversedTranslation = TranslateSentenceAction::translate($sentence, true);

        // Obtain our translated runic sentence both forwards and backwards.
        foreach ([$normalTranslation, $reversedTranslation] as $translation) {

            // Our permutation library is chunky, so break down the strings into all permutations of the letters.
            GeneratePermutation::reset();
            GeneratePermutation::handle($translation);
            $permutations = GeneratePermutation::$permutations;

            foreach ($permutations as $permutation) {
                foreach (range(1, 26) as $rotation) {
                    // Iterate all 26 possible rotations for the permutation looking for English words.
                }
            }
        }

        return self::SUCCESS;
    }
}
