<?php

namespace App\Commands;

use App\Actions\Files\ParseWordlistsIntoArray;
use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Actions\Runes\TranslateVigenere as TranslateVigenereAction;
use LaravelZero\Framework\Commands\Command;

class BruteforceVigenereKey extends Command
{
    protected $signature = 'app:bruteforce-vigenere {sentence?}';

    protected $description = 'Attempt to bruteforce a Vigenere key from wordlists.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to bruteforce');

        $folder = app_path('../../wordlists');
        $words = ParseWordlistsIntoArray::handle($folder);

        $tableHeader = ['Word', 'Translation', 'Reversed Translation'];
        $tableData = [];

        $this->output->write('Iterating through '.count($words).' wordlists...'.PHP_EOL);

        foreach ($words as $word) {
            // If word contains numbers - abandon as it's not a valid key.
            if (preg_match('/\d/', $word)) {
                continue;
            }

            $runicKey = GenerateRunesFromEnglish::handle($word);

            // We may have a word that doesn't translate to runes.
            if (count($runicKey) === 0) {
                continue;
            }

            $translation = TranslateVigenereAction::translate($sentence, $runicKey);
            $reversedTranslation = TranslateVigenereAction::translate($sentence, $runicKey, [], true);

            $tableData[] = [
                'word' => $word,
                'translation' => $translation,
                'reversedTranslation' => $reversedTranslation,
            ];
        }

        $this->output->write(PHP_EOL);

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }
}
