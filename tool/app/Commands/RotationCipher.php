<?php

namespace App\Commands;

use App\Actions\Runes\RunicRotationCipher;
use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use LaravelZero\Framework\Commands\Command;

class RotationCipher extends Command
{
    protected $signature = 'app:rotation-cipher {sentence?} {--rotation=} {--runic-shift}';

    protected $description = 'Takes runic sentence to run ROT# cipher forwards and backwards.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $rotation = (int) $this->option('rotation');
        $isRunic = (bool) $this->option('runic-shift');

        $normalTranslation = TranslateSentenceAction::translate($sentence);
        $reversedTranslation = TranslateSentenceAction::translate($sentence, true);
        $this->info('Dumping normal, then reversed translation.');

        foreach ([$normalTranslation, $reversedTranslation] as $translation) {
            $plaintext = $isRunic
                ? RunicRotationCipher::handle($translation, $rotation)
                : \App\Actions\Strings\RotationCipher::handle($translation, $rotation);

            $this->info($plaintext);
            $this->newLine();
        }

        return self::SUCCESS;
    }
}
