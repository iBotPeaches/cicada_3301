<?php

namespace App\Commands;

use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use LaravelZero\Framework\Commands\Command;

class TranslateSentence extends Command
{
    protected $signature = 'app:translate {sentence?}';

    protected $description = 'Translate Sentence';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');

        $translation = TranslateSentenceAction::translate($sentence);
        $reversedTranslation = TranslateSentenceAction::translate($sentence, true);

        $this->output->write('Translation: '.$translation.PHP_EOL);
        $this->output->write('Reversed Translation: '.$reversedTranslation.PHP_EOL);

        return self::SUCCESS;
    }
}
