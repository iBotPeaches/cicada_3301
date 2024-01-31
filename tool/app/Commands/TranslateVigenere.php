<?php

namespace App\Commands;

use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Actions\Runes\TranslateVigenere as TranslateVigenereAction;
use LaravelZero\Framework\Commands\Command;

class TranslateVigenere extends Command
{
    protected $signature = 'app:vigenere';

    protected $description = 'Translate Vigènere Sentence';

    public function handle(): int
    {
        $sentence = $this->ask('Enter a sentence to translate', 'ᚢᛠᛝᛋᛇᚠᚳ ᚱᛇᚢᚷᛈᛠᛠ ᚠᚹᛉ');
        $key = $this->ask('Enter the key.', 'divinity');
        $runicKey = GenerateRunesFromEnglish::handle($key);

        $translation = TranslateVigenereAction::translate($sentence, $runicKey);
        $reversedTranslation = TranslateVigenereAction::translate($sentence, $runicKey, true);

        $this->output->write('Translation: '.$translation.PHP_EOL);
        $this->output->write('Reversed Translation: '.$reversedTranslation.PHP_EOL);

        return self::SUCCESS;
    }
}
