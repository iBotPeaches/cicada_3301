<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Enums\Rune;
use Tests\TestCase;

class BruteforceRotationCipherTest extends TestCase
{
    public function test_latin_rotation_uses_each_permutation(): void
    {
        $sentence = implode('', array_map(fn (Rune $rune) => $rune->value, GenerateRunesFromEnglish::handle('welcome')));

        $this->artisan('app:bruteforce-rotation-cipher', ['sentence' => $sentence])
            ->expectsOutputToContain('| WELCOME     | 0        | WELCOME   |')
            ->expectsOutputToContain('| WELKOME     | 0        | WELKOME   |')
            ->assertOk();
    }

    public function test_runic_rotation_covers_all_runes(): void
    {
        // Shift every rune back by one so that only a rotation of 28 recovers the plaintext.
        $runes = GenerateRunesFromEnglish::handle('welcome');
        $sentence = implode('', array_map(fn (Rune $rune) => Rune::tryFromIndex(($rune->toNumericPosition() + 1) % 29)->value, $runes));

        $this->artisan('app:bruteforce-rotation-cipher', ['sentence' => $sentence, '--runic-shift' => true])
            ->expectsOutputToContain('| WELCOME        | 28       | WEL[C|K]OME            |')
            ->assertOk();
    }
}
