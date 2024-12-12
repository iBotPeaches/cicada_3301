<?php

namespace App\Commands;

use App\Actions\Files\FilterWordlists;
use LaravelZero\Framework\Commands\Command;

class DumpWordlists extends Command
{
    protected $signature = 'app:wordlists {min=1}';

    protected $description = 'Dump wordlists to stdout.';

    public function handle(): int
    {
        $wordlistFolder = app_path('../../wordlists');
        $wordlists = FilterWordlists::handle($wordlistFolder, $this->argument('min'));

        foreach ($wordlists as $word) {
            $this->line($word);
        }

        return self::SUCCESS;
    }
}
