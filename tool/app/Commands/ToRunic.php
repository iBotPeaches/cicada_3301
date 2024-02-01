<?php

namespace App\Commands;

use App\Actions\Runes\GenerateRunesFromEnglish;
use LaravelZero\Framework\Commands\Command;

class ToRunic extends Command
{
    protected $signature = 'app:to-runic {sentence?}';

    protected $description = 'Take an English word to Runes';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to runify');

        $runes = GenerateRunesFromEnglish::handle($sentence);
        foreach ($runes as $rune) {
            $this->output->write($rune->value);
        }

        $this->output->write(PHP_EOL);

        return self::SUCCESS;
    }
}
