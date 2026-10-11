<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class VisualizeRunesTest extends TestCase
{
    public function test_rows_are_labelled_correctly(): void
    {
        $this->artisan('app:visualize-runes', ['sentence' => 'ᚢ'])
            ->expectsTable(['Rune', 'ᚢ'], [
                ['Value', 3],
                ['Letter', 'U'],
                ['Index', 1],
                ['Reversed Index', 27],
            ])
            ->assertExitCode(0);
    }
}
