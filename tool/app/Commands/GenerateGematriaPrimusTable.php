<?php

namespace App\Commands;

use App\Enums\Rune;
use LaravelZero\Framework\Commands\Command;

class GenerateGematriaPrimusTable extends Command
{
    protected $signature = 'app:generate-gematria-primus-table';

    protected $description = 'Generates markdown table for Gematria Primus.';

    public function handle(): int
    {
        $tableHeader = ['Rune', 'Letter', 'Value', 'Index', 'Reversed Index', 'Unicode'];
        $tableData = [];

        collect(Rune::cases())->each(function (Rune $rune) use (&$tableData) {
            $tableData[] = [
                $rune->toRune(),
                $rune->toSingleLetter(),
                $rune->toInt(),
                $rune->toNumericPosition(),
                $rune->toReversedNumericPosition(),
                'U+'.$rune->toUnicode(),
            ];
        });

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }
}
