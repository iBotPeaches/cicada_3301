<?php

namespace App\Commands;

use App\Actions\Runes\SplitSentenceToRuneEnums;
use LaravelZero\Framework\Commands\Command;

class BruteforcePrimeCipher extends Command
{
    protected $signature = 'app:bruteforce-prime-cipher {sentence?} {--shift=}';

    protected $description = 'Takes runic sentence and performs a prime cipher bruteforce with an optional shift.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $shift = $this->option('shift') ?? 0;

        $runes = SplitSentenceToRuneEnums::handle($sentence);

        $test = '';

        return self::SUCCESS;
    }
}
