<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\TranslateVigenere;
use App\Enums\Rune;
use Tests\TestCase;

class TranslateVigenereActionTest extends TestCase
{
    public function test_unrecognized_characters_are_preserved(): void
    {
        $this->assertSame('FU-TH.O', TranslateVigenere::translate('ᚠᚢ-ᚦ.ᚩ', [Rune::F]));
    }
}
