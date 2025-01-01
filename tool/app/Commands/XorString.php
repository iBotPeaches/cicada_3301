<?php

namespace App\Commands;

use App\Actions\Strings\XorWords;
use LaravelZero\Framework\Commands\Command;

class XorString extends Command
{
    protected $signature = 'app:xor-string {string?} {key?}';

    protected $description = 'XOR String with a variety of files from previous puzzles.';

    public function handle(): int
    {
        $string = $this->argument('string') ?? $this->ask('Enter a string to XOR');
        $key = $this->argument('key') ?? $this->ask('Enter the key.');

        $output = XorWords::handle($string, $key);

        $this->output->write('XOR: '.$output.PHP_EOL);

        return self::SUCCESS;
    }
}
