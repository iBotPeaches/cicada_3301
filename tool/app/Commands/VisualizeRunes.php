<?php

namespace App\Commands;

use App\Actions\Runes\SplitSentenceToRuneEnums;
use App\Enums\Rune;
use LaravelZero\Framework\Commands\Command;

class VisualizeRunes extends Command
{
    protected $signature = 'app:visualize-runes {sentence?}';

    protected $description = 'Renders a visualization of a sentence with indexes and Gematria values.';

    public function handle(): int
    {
        $sentence = $this->argument('sentence') ?? $this->ask('Enter a sentence to translate');
        $letters = SplitSentenceToRuneEnums::handle($sentence);

        $header = $letters->map(fn (Rune|string $rune) => is_string($rune) ? $rune : $rune->toRune())->toArray();
        $value = $letters->map(fn (Rune|string $rune) => is_string($rune) ? ' ' : $rune->toInt())->toArray();
        $singleLetter = $letters->map(fn (Rune|string $rune) => is_string($rune) ? ' ' : $rune->toSingleLetter())->toArray();
        $index = $letters->map(fn (Rune|string $rune) => is_string($rune) ? ' ' : $rune->toNumericPosition())->toArray();
        $reversedIndex = $letters->map(fn (Rune|string $rune) => is_string($rune) ? ' ' : $rune->toReversedNumericPosition())->toArray();

        // rows
        $runicRow = array_merge(['Rune'], $header);
        $valueRow = array_merge(['Index'], $value);
        $singleLetterRow = array_merge(['Letter'], $singleLetter);
        $indexRow = array_merge(['Value'], $index);
        $reversedIndexRow = array_merge(['Reversed Index'], $reversedIndex);

        $this->table($runicRow, [
            $valueRow,
            $singleLetterRow,
            $indexRow,
            $reversedIndexRow,
        ]);

        return self::SUCCESS;
    }
}
