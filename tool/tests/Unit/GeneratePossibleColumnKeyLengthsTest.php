<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Strings\GeneratePossibleColumnKeyLengths;
use Tests\TestCase;

class GeneratePossibleColumnKeyLengthsTest extends TestCase
{
    public function test_odd_length_returns_integer_divisors(): void
    {
        $this->assertSame([1, 3, 5], GeneratePossibleColumnKeyLengths::handle('abcdefghijklmno'));
    }

    public function test_spaces_are_ignored(): void
    {
        $this->assertSame([1, 2, 3], GeneratePossibleColumnKeyLengths::handle('TL BE IE'));
    }

    public function test_empty_sentence_has_no_key_lengths(): void
    {
        $this->assertSame([], GeneratePossibleColumnKeyLengths::handle(''));
    }
}
