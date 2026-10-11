<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Enums\Rune;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BruteforceRotationCipherTest extends TestCase
{
    public function test_latin_rotation_uses_each_permutation(): void
    {
        $sentence = implode('', array_map(fn (Rune $rune) => $rune->value, GenerateRunesFromEnglish::handle('welcome')));

        Artisan::call('app:bruteforce-rotation-cipher', ['sentence' => $sentence]);
        $output = Artisan::output();

        $this->assertMatchesRegularExpression('/\|\s*WELCOME\s*\|\s*0\s*\|\s*WELCOME\s*\|/', $output);
        $this->assertMatchesRegularExpression('/\|\s*WELKOME\s*\|\s*0\s*\|\s*WELKOME\s*\|/', $output);
    }

    public function test_runic_rotation_covers_all_runes(): void
    {
        // Shift every rune back by one so that only a rotation of 28 recovers the plaintext.
        $runes = GenerateRunesFromEnglish::handle('welcome');
        $sentence = implode('', array_map(fn (Rune $rune) => Rune::tryFromIndex(($rune->toNumericPosition() + 1) % 29)->value, $runes));

        Artisan::call('app:bruteforce-rotation-cipher', ['sentence' => $sentence, '--runic-shift' => true]);

        $this->assertMatchesRegularExpression('/\|\s*WELCOME\s*\|\s*28\s*\|/', Artisan::output());
    }
}
