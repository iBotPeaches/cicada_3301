<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\RunicRotationCipher;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RunicRotationCipherTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_runic_rotation(string $text, int $rotation, bool $reversed, string $expected): void
    {
        $this->assertSame($expected, RunicRotationCipher::handle($text, $rotation, $reversed));
    }

    public static function dataProvider(): array
    {
        return [
            'wraps forward' => ['text' => 'ᛠ', 'rotation' => 1, 'reversed' => false, 'expected' => 'F'],
            'max rotation' => ['text' => 'ᚠ', 'rotation' => 28, 'reversed' => false, 'expected' => 'EA'],
            'negative rotation' => ['text' => 'ᚠᚢ', 'rotation' => -1, 'reversed' => false, 'expected' => 'EAF'],
            'reversed' => ['text' => 'ᚠᚢ', 'rotation' => 1, 'reversed' => true, 'expected' => 'FEA'],
            'non-runes preserved' => ['text' => 'ᚠ-ᚢ. 3', 'rotation' => 1, 'reversed' => false, 'expected' => 'U-TH. 3'],
            // Adjacent runes reversing to O + E must not merge into the single OE rune, and vice versa.
            'adjacent o and e stay separate' => ['text' => 'ᚫᛁ', 'rotation' => 3, 'reversed' => true, 'expected' => 'G[NG|ING]'],
            'adjacent e and a stay separate' => ['text' => 'ᛁᚱ', 'rotation' => 3, 'reversed' => true, 'expected' => '[NG|ING][IA|IO]'],
            'adjacent t and h stay separate' => ['text' => 'ᛇᛚ', 'rotation' => 3, 'reversed' => true, 'expected' => 'MJ'],
            'oe rune shifts as one' => ['text' => 'ᚷ', 'rotation' => 3, 'reversed' => true, 'expected' => 'AE'],
        ];
    }
}
