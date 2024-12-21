<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BruteforceVigenereTest extends TestCase
{
    public function test_bruteforce_vigenere(): void
    {
        $sentence = 'ᚢᛠᛝᛋᛇᚠᚳ ᚱᛇᚢᚷᛈᛠᛠ ᚠᚹᛉ';

        $this->artisan('app:bruteforce-vigenere')
            ->expectsQuestion('Enter a sentence to bruteforce', $sentence)
            ->expectsOutputToContain('divinity')
            ->assertExitCode(0);
    }
}
