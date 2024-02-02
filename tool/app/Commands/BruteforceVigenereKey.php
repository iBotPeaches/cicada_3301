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
        $bar = $this->output->createProgressBar(count($words));
        $bar->start();

        foreach ($words as $word) {
            $runicKey = GenerateRunesFromEnglish::handle($word);

            // We may have a word that doesn't translate to runes.
            if (count($runicKey) === 0) {
                $bar->advance();

                continue;
            }

            $translation = TranslateVigenereAction::translate($sentence, $runicKey);
            $reversedTranslation = TranslateVigenereAction::translate($sentence, $runicKey, true);

            $tableData[] = [
                'word' => $word,
                'translation' => $translation,
                'reversedTranslation' => $reversedTranslation,
            ];

            $bar->advance();
        }

        $bar->finish();

        $this->output->write(PHP_EOL);

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }
}
