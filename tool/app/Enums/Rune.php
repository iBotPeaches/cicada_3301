<?php

declare(strict_types=1);

namespace App\Enums;

enum Rune: string
{
    case F = 'ᚠ'; // fehu - Code Point: U+16A0
    case U = 'ᚢ'; // uruz - Code Point: U+16A2
    case TH = 'ᚦ'; // thurisaz - Code Point: U+16A6
    case O = 'ᚩ'; // os - Code Point: U+16A9
    case R = 'ᚱ'; // raido - Code Point: U+16B1
    case C_OR_K = 'ᚳ'; // kaun - Code Point: U+16B3
    case G = 'ᚷ'; // gyfu - Code Point: U+16B7
    case W = 'ᚹ'; // wunjo - Code Point: U+16B9
    case H = 'ᚺ'; // hagalaz - Code Point: U+16BA
    case N = 'ᚾ'; // naudiz - Code Point: U+16BE
    case I = 'ᛁ'; // isaz - Code Point: U+16C1
    case J = 'ᛃ'; // jera - Code Point: U+16C3
    case EO = 'ᛇ'; // eihwaz - Code Point: U+16C7
    case P = 'ᛈ'; // pertho - Code Point: U+16C8
    case X = 'ᛉ'; // algiz - Code Point: U+16C9
    case S_OR_Z = 'ᛊ'; // sowilo - Code Point: U+16CA
    case T = 'ᛏ'; // tiwaz - Code Point: U+16CF
    case B = 'ᛒ'; // berkano - Code Point: U+16D2
    case E = 'ᛖ'; // ehwaz - Code Point: U+16D6
    case M = 'ᛗ'; // mannaz - Code Point: U+16D7
    case L = 'ᛚ'; // laguz - Code Point: U+16DA
    case NG_OR_ING = 'ᛜ'; // ingwaz - Code Point: U+16DC
    case OE = 'ᛟ'; // othala - Code Point: U+16DF
    case D = 'ᛞ'; // dagaz - Code Point: U+16DE
    case A = 'ᚪ'; // ansuz - Code Point: U+16AA
    case AE = 'ᚫ'; // aesc - Code Point: U+16AB
    case Y = 'ᛦ'; // yr - Code Point: U+16E6
    case IA_OR_IO = 'ᛡ'; // io - Code Point: U+16E1
    case EA = 'ᛠ'; // ear - Code Point: U+16E0

    public function toLetter(): string|array
    {
        return match ($this) {
            self::C_OR_K => ['C', 'K'],
            self::S_OR_Z => ['S', 'Z'],
            self::NG_OR_ING => ['NG', 'ING'],
            self::IA_OR_IO => ['IA', 'IO'],
            default => $this->toSingleLetter()
        };
    }

    public function toSingleLetter(): string
    {
        return match ($this) {
            self::F => 'F',
            self::U => 'U',
            self::TH => 'TH',
            self::O => 'O',
            self::R => 'R',
            self::C_OR_K => '[C|K]',
            self::G => 'G',
            self::W => 'W',
            self::H => 'H',
            self::N => 'N',
            self::I => 'I',
            self::J => 'J',
            self::EO => 'EO',
            self::P => 'P',
            self::X => 'X',
            self::S_OR_Z => '[S|Z]',
            self::T => 'T',
            self::B => 'B',
            self::E => 'E',
            self::M => 'M',
            self::L => 'L',
            self::NG_OR_ING => '[NG|ING]',
            self::OE => 'OE',
            self::D => 'D',
            self::A => 'A',
            self::AE => 'AE',
            self::Y => 'Y',
            self::IA_OR_IO => '[IA|IO]',
            self::EA => 'EA',
        };
    }

    public function toInt(): int
    {
        return match ($this) {
            self::F => 2,
            self::U => 3,
            self::TH => 5,
            self::O => 7,
            self::R => 11,
            self::C_OR_K => 13,
            self::G => 17,
            self::W => 19,
            self::H => 23,
            self::N => 29,
            self::I => 31,
            self::J => 37,
            self::EO => 41,
            self::P => 43,
            self::X => 47,
            self::S_OR_Z => 53,
            self::T => 59,
            self::B => 61,
            self::E => 67,
            self::M => 71,
            self::L => 73,
            self::NG_OR_ING => 79,
            self::OE => 83,
            self::D => 89,
            self::A => 97,
            self::AE => 101,
            self::Y => 103,
            self::IA_OR_IO => 107,
            self::EA => 109,
            default => \InvalidArgumentException::class
        };
    }
}
