<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Strings\XorWords;
use Tests\TestCase;

class XorWordsTest extends TestCase
{
    public function test_odd_length_hex_looking_word_is_treated_as_text(): void
    {
        $this->assertSame('bad' ^ 'key', XorWords::handle('bad', 'key'));
    }

    public function test_whitespace_and_null_bytes_are_preserved(): void
    {
        $this->assertSame(' [', XorWords::handle('XY', "x\x02"));
        $this->assertSame("\0\0", XorWords::handle('ZZ', 'ZZ'));
    }
}
