<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class SimpleCommandsTest extends TestCase
{
    public function test_dump_wordlists_filters_by_length(): void
    {
        $this->artisan('app:wordlists', ['min' => 8])
            ->expectsOutput('divinity')
            ->doesntExpectOutput('we')
            ->assertOk();
    }

    public function test_gematria_primus_table(): void
    {
        $this->artisan('app:generate-gematria-primus-table')
            ->expectsOutputToContain('| ᚠ    | F        | 2     | 0     | 28             | U+16A0  |')
            ->expectsOutputToContain('| ᛠ    | EA       | 109   | 28    | 0              | U+16E0  |')
            ->assertOk();
    }

    public function test_rotation_cipher(): void
    {
        $this->artisan('app:rotation-cipher', ['sentence' => 'ᚠᚢ', '--rotation' => 1])
            ->expectsOutput('GV')
            ->expectsOutput('FB[JB|JP]')
            ->assertOk();
    }

    public function test_runic_rotation_cipher(): void
    {
        $this->artisan('app:rotation-cipher', ['sentence' => 'ᚠᚢ', '--rotation' => 1, '--runic-shift' => true])
            ->expectsOutput('UTH')
            ->expectsOutput('FEA')
            ->assertOk();
    }
}
