<?php

namespace App\Commands;

use App\Actions\Files\FileToHex;
use App\Actions\Strings\XorWords;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforceXor extends Command
{
    protected $signature = 'app:bruteforce-xor {text?}';

    protected $description = 'Attempt XOR with a variety of Cicada OS files.';

    public function handle(): int
    {
        $text = $this->argument('text') ?? $this->ask('Enter text to preform XOR permutation on.');
        $iso = app_path('../../iso/unpacked');

        $tableHeader = ['Word', 'File'];
        $tableData = [];

        $files = [
            $iso.'/AUDIO/761.MP3',
            $iso.'/DATA/_560.00',
            $iso.'/DATA/560.13',
            $iso.'/DATA/560.17',
        ];

        foreach ($files as $file) {
            $fileContents = FileToHex::handle($file);
            $xored = XorWords::handle($text, $fileContents);

            $tableData[] = [
                'word' => ctype_alnum($xored) ? Str::limit($xored, 128) : '<binary>',
                'file' => basename($file),
            ];
        }

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }
}
