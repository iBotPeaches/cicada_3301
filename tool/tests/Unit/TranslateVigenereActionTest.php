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

    public function test_numbers_are_not_shifted(): void
    {
        $this->assertSame('F3U', TranslateVigenere::translate('ᚠ3ᚢ', [Rune::F]));
    }

    public function test_skipped_indexes_do_not_consume_key(): void
    {
        $this->assertSame('EAF', TranslateVigenere::translate('ᚠᚢ', [Rune::U]));
        $this->assertSame('FF', TranslateVigenere::translate('ᚠᚢ', [Rune::U], [1]));
    }

    public function test_empty_key_throws(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        TranslateVigenere::translate('ᚠ', []);
    }
}
