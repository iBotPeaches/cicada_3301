<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\RunicRotationCipher;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RunicRotationCipherTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_runic_rotation(string $text, int $rotation, string $expected): void
    {
        $this->assertSame($expected, RunicRotationCipher::handle($text, $rotation));
    }

    public static function dataProvider(): array
    {
        return [
            'wraps forward' => ['text' => 'EA', 'rotation' => 1, 'expected' => 'F'],
            'max rotation' => ['text' => 'F', 'rotation' => 28, 'expected' => 'EA'],
            'negative rotation' => ['text' => 'FU', 'rotation' => -1, 'expected' => 'EAF'],
            'unknown characters preserved' => ['text' => 'FU[?]TH[?]', 'rotation' => 0, 'expected' => 'FU?TH?'],
            'letters without runes preserved' => ['text' => 'QF', 'rotation' => 1, 'expected' => 'QU'],
            'numbers preserved' => ['text' => 'F 3', 'rotation' => 1, 'expected' => 'U 3'],
        ];
    }
}
