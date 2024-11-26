<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Strings\RotationCipher;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RotationCipherTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_sentence_decoding(string $text, string $expected, int $rotation): void
    {
        $this->assertSame($expected, RotationCipher::handle($text, $rotation));
    }

    public static function dataProvider(): array
    {
        return [
            [
                'text' => 'docd',
                'expected' => 'test',
                'rotation' => 16,
            ],
        ];
    }
}
