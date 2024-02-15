<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class XorString extends Command
{
    protected $signature = 'app:xor-string';

    protected $description = 'XOR String with a variety of files from previous puzzles.';

    public function handle(): int
    {
        $string = $this->ask('Enter a string to XOR');
        $key = $this->ask('Enter the key.');

        $xor1 = gmp_init($string, 16);
        $xor2 = gmp_init($key, 16);

        $xor = gmp_xor($xor1, $xor2);
        $output = pack('H*', gmp_strval($xor, 16));

        $this->output->write('XOR: '.$output.PHP_EOL);

        return self::SUCCESS;
    }
}
