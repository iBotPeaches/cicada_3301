<?php

namespace App\Commands;

use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Actions\Runes\TranslateVigenere as TranslateVigenereAction;
use LaravelZero\Framework\Commands\Command;

class TranslateVigenere extends Command
{
    protected $signature = 'app:vigenere {sentence?} {key?} {indexesToSkip?}';

    protected $description = 'Translate Vigènere Sentence';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $key = $this->argument('key') ?? $this->ask('Enter the key.');
        $indexesToSkip = $this->argument('indexesToSkip') ?? $this->ask('Enter the indexes to skip.');
        $runicKey = GenerateRunesFromEnglish::handle($key);
        $indexesToSkip = array_values(array_map('intval', array_filter(array_map('trim', explode(',', (string) $indexesToSkip)), 'is_numeric')));

        $translation = TranslateVigenereAction::translate($sentence, $runicKey, $indexesToSkip);
        $reversedTranslation = TranslateVigenereAction::translate($sentence, $runicKey, $indexesToSkip, true);

        $this->output->write('Translation: '.$translation.PHP_EOL);
        $this->output->write(PHP_EOL);
        $this->output->write('Reversed Translation: '.$reversedTranslation.PHP_EOL);

        return self::SUCCESS;
    }
}
