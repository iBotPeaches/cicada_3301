<?php

namespace App\Commands;

use App\Actions\Ciphers\GeneratePlaintextFromPrimeShiftedCipher;
use App\Actions\Files\FilterWordlists;
use App\Actions\Runes\SplitSentenceToRuneEnums;
use App\Enums\Rune;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforcePrimeCipher extends Command
{
    protected $signature = 'app:bruteforce-prime-cipher {sentence?} {--shift=} {indexesToSkip?}';

    protected $description = 'Takes runic sentence and performs a prime cipher bruteforce with an optional shift.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $shift = $this->option('shift') ?? null;
        $indexesToSkip = Arr::wrap($this->argument('indexesToSkip') ?? []);

        $folder = app_path('../../wordlists');
        $dictionaryWords = FilterWordlists::handle($folder, 2);
        $countOfRunes = count(Rune::cases());

        $runes = SplitSentenceToRuneEnums::handle($sentence);

        $tableHeader = ['Shift', 'Plaintext'];
        $tableData = [];
        if (is_null($shift)) {
            $this->info('No shift provided. Attempting to bruteforce prime cipher with all shifts...');

            foreach (range(0, $countOfRunes) as $shift) {
                $plaintext = GeneratePlaintextFromPrimeShiftedCipher::handle($runes, $shift, $indexesToSkip);

                if (Str::contains($plaintext, $dictionaryWords, ignoreCase: true)) {
                    $tableData[] = [
                        'shift' => $shift,
                        'plaintext' => Str::limit($plaintext),
                    ];
                }
            }

            $this->table($tableHeader, $tableData);

            return self::SUCCESS;
        }

        $plaintext = GeneratePlaintextFromPrimeShiftedCipher::handle($runes, $shift, $indexesToSkip);
        $this->info('Shift provided: '.$shift);
        $this->info('Indexes to skip: '.implode(', ', $indexesToSkip));
        $this->newLine();
        $this->info($plaintext);

        return self::SUCCESS;
    }
}
