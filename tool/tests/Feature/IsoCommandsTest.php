<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class IsoCommandsTest extends TestCase
{
    private function isoPresent(): bool
    {
        return file_exists(app_path('../../iso/unpacked/DATA/560.13'));
    }

    public function test_shamir_solve_extracts_onion(): void
    {
        if (! $this->isoPresent()) {
            $this->markTestSkipped('ISO not downloaded. Run ./scripts/download_iso.sh.');
        }

        $this->artisan('app:shamir-solve')
            ->expectsOutputToContain('4l6uipnstbggwjyv.onion')
            ->assertOk();
    }

    public function test_bruteforce_xor_covers_each_file(): void
    {
        if (! $this->isoPresent()) {
            $this->markTestSkipped('ISO not downloaded. Run ./scripts/download_iso.sh.');
        }

        $this->artisan('app:bruteforce-xor', ['text' => 'hello'])
            ->expectsOutputToContain('761.MP3')
            ->expectsOutputToContain('560.17')
            ->assertOk();
    }
}
