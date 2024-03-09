<?php

namespace App\Commands;

use App\Actions\Strings\GeneratePermutation;
use LaravelZero\Framework\Commands\Command;

class ToPermutation extends Command
{
    protected $signature = 'app:permutation {sentence?}';

    protected $description = 'Iterates string with [A/C] swaps to iterate all strings..';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to preform permutation on.');
        $permutations = GeneratePermutation::handle($sentence);

        foreach ($permutations as $keyPermutation) {
            $this->output->write($keyPermutation.PHP_EOL);
        }

        return self::SUCCESS;
    }
}
