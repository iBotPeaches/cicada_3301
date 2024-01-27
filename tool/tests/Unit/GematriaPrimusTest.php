<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Rune;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GematriaPrimusTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testProperCoalesceOfRunes(Rune $rune, string $raw, string|array $letter, string $singleLetter, int $value): void
    {
        $this->assertSame($raw, $rune->value);
        $this->assertSame($letter, $rune->toLetter());
        $this->assertSame($singleLetter, $rune->toSingleLetter());
        $this->assertSame($value, $rune->toInt());
    }

    public static function dataProvider(): array
    {
        return [
            'f' => [
                'rune' => Rune::F,
                'raw' => "\u{16A0}",
                'letter' => 'F',
                'singleLetter' => 'F',
                'value' => 2,
            ],
            'u' => [
                'rune' => Rune::U,
                'raw' => "\u{16A2}",
                'letter' => 'U',
                'singleLetter' => 'U',
                'value' => 3,
            ],
            'th' => [
                'rune' => Rune::TH,
                'raw' => "\u{16A6}",
                'letter' => 'TH',
                'singleLetter' => 'TH',
                'value' => 5,
            ],
            'o' => [
                'rune' => Rune::O,
                'raw' => "\u{16A9}",
                'letter' => 'O',
                'singleLetter' => 'O',
                'value' => 7,
            ],
            'r' => [
                'rune' => Rune::R,
                'raw' => "\u{16B1}",
                'letter' => 'R',
                'singleLetter' => 'R',
                'value' => 11,
            ],
            'c_or_k' => [
                'rune' => Rune::C_OR_K,
                'raw' => "\u{16B3}",
                'letter' => ['C', 'K'],
                'singleLetter' => '[C|K]',
                'value' => 13,
            ],
            'g' => [
                'rune' => Rune::G,
                'raw' => "\u{16B7}",
                'letter' => 'G',
                'singleLetter' => 'G',
                'value' => 17,
            ],
            'w' => [
                'rune' => Rune::W,
                'raw' => "\u{16B9}",
                'letter' => 'W',
                'singleLetter' => 'W',
                'value' => 19,
            ],
            'h' => [
                'rune' => Rune::H,
                'raw' => "\u{16BA}",
                'letter' => 'H',
                'singleLetter' => 'H',
                'value' => 23,
            ],
            'n' => [
                'rune' => Rune::N,
                'raw' => "\u{16BE}",
                'letter' => 'N',
                'singleLetter' => 'N',
                'value' => 29,
            ],
            'i' => [
                'rune' => Rune::I,
                'raw' => "\u{16C1}",
                'letter' => 'I',
                'singleLetter' => 'I',
                'value' => 31,
            ],
            'j' => [
                'rune' => Rune::J,
                'raw' => "\u{16C3}",
                'letter' => 'J',
                'singleLetter' => 'J',
                'value' => 37,
            ],
            'eo' => [
                'rune' => Rune::EO,
                'raw' => "\u{16C7}",
                'letter' => 'EO',
                'singleLetter' => 'EO',
                'value' => 41,
            ],
            'p' => [
                'rune' => Rune::P,
                'raw' => "\u{16C8}",
                'letter' => 'P',
                'singleLetter' => 'P',
                'value' => 43,
            ],
            'x' => [
                'rune' => Rune::X,
                'raw' => "\u{16C9}",
                'letter' => 'X',
                'singleLetter' => 'X',
                'value' => 47,
            ],
            's_or_z' => [
                'rune' => Rune::S_OR_Z,
                'raw' => "\u{16CA}",
                'letter' => ['S', 'Z'],
                'singleLetter' => '[S|Z]',
                'value' => 53,
            ],
            't' => [
                'rune' => Rune::T,
                'raw' => "\u{16CF}",
                'letter' => 'T',
                'singleLetter' => 'T',
                'value' => 59,
            ],
            'b' => [
                'rune' => Rune::B,
                'raw' => "\u{16D2}",
                'letter' => 'B',
                'singleLetter' => 'B',
                'value' => 61,
            ],
            'e' => [
                'rune' => Rune::E,
                'raw' => "\u{16D6}",
                'letter' => 'E',
                'singleLetter' => 'E',
                'value' => 67,
            ],
            'm' => [
                'rune' => Rune::M,
                'raw' => "\u{16D7}",
                'letter' => 'M',
                'singleLetter' => 'M',
                'value' => 71,
            ],
            'l' => [
                'rune' => Rune::L,
                'raw' => "\u{16DA}",
                'letter' => 'L',
                'singleLetter' => 'L',
                'value' => 73,
            ],
            'ng_or_ing' => [
                'rune' => Rune::NG_OR_ING,
                'raw' => "\u{16DC}",
                'letter' => ['NG', 'ING'],
                'singleLetter' => '[NG|ING]',
                'value' => 79,
            ],
            'oe' => [
                'rune' => Rune::OE,
                'raw' => "\u{16DF}",
                'letter' => 'OE',
                'singleLetter' => 'OE',
                'value' => 83,
            ],
            'd' => [
                'rune' => Rune::D,
                'raw' => "\u{16DE}",
                'letter' => 'D',
                'singleLetter' => 'D',
                'value' => 89,
            ],
            'a' => [
                'rune' => Rune::A,
                'raw' => "\u{16AA}",
                'letter' => 'A',
                'singleLetter' => 'A',
                'value' => 97,
            ],
            'ae' => [
                'rune' => Rune::AE,
                'raw' => "\u{16AB}",
                'letter' => 'AE',
                'singleLetter' => 'AE',
                'value' => 101,
            ],
            'y' => [
                'rune' => Rune::Y,
                'raw' => "\u{16E6}",
                'letter' => 'Y',
                'singleLetter' => 'Y',
                'value' => 103,
            ],
            'ia_or_io' => [
                'rune' => Rune::IA_OR_IO,
                'raw' => "\u{16E1}",
                'letter' => ['IA', 'IO'],
                'singleLetter' => '[IA|IO]',
                'value' => 107,
            ],
            'ea' => [
                'rune' => Rune::EA,
                'raw' => "\u{16E0}",
                'letter' => 'EA',
                'singleLetter' => 'EA',
                'value' => 109,
            ],
        ];
    }
}
