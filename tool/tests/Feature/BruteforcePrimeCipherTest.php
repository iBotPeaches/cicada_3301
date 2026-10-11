<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BruteforcePrimeCipherTest extends TestCase
{
    public function test_bruteforce_prime_cipher(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ ᚳᚦᚷᚹ ᚹᛚᚫ ᛉᚩᚪᛈ ᛗᛞᛞᚢᚷᚹ ᛚ ᛞᚾᚣᛄ ᚳᚠᛡ ᚫᛏᛈᛇᚪᚦ ᚳᚫ 3';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence, '--shift' => 1])
            ->expectsOutputToContain('Shift provided: 1')
            ->expectsOutputToContain('AN END WITHIN THE DEEP WEB THERE EXI[S|Z]T[S|Z] A PAGE THAT HA[S|Z]HE[S|Z] TO 3');
    }

    public function test_multiple_indexes_can_be_skipped(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence, 'indexesToSkip' => '0,1', '--shift' => 1])
            ->expectsOutputToContain('Indexes to skip: 0, 1')
            ->expectsOutputToContain('AEJ ')
            ->assertExitCode(0);
    }
}
