<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\GenerateRunesFromEnglish;
use App\Enums\Rune;
use Tests\TestCase;

class GenerateRunesFromEnglishTest extends TestCase
{
    public function test_try_handle_returns_null_for_untranslatable_words(): void
    {
        $this->assertNull(GenerateRunesFromEnglish::tryHandle('queen'));
        $this->assertNull(GenerateRunesFromEnglish::tryHandle("don't"));
    }

    public function test_try_handle_returns_runes(): void
    {
        $this->assertSame([Rune::F, Rune::U], GenerateRunesFromEnglish::tryHandle('fu'));
    }
}
