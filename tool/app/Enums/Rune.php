<?php

declare(strict_types=1);

namespace App\Enums;

enum Rune: string
{
    case F = 'ᚠ';
    case U = 'ᚢ';
    case TH = 'ᚦ';
    case O = 'ᚩ';
    case R = 'ᚱ';
    case C_OR_K = 'ᚳ';
    case G = 'ᚷ';
    case W = 'ᚹ';
    case H = 'ᚻ';
    case N = 'ᚾ';
    case I = 'ᛁ';
    case J = 'ᛄ';
    case EO = 'ᛇ';
    case P = 'ᛈ';
    case X = 'ᛉ';
    case S_OR_Z = 'ᛋ';
    case T = 'ᛏ';
    case B = 'ᛒ';
    case E = 'ᛖ';
    case M = 'ᛗ';
    case L = 'ᛚ';
    case NG_OR_ING = 'ᛝ';
    case OE = 'ᛟ';
    case D = 'ᛞ';
    case A = 'ᚪ';
    case AE = 'ᚫ';
    case Y = 'ᚣ';
    case IA_OR_IO = 'ᛡ';
    case EA = 'ᛠ';

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

    public function toReversedLetter(): string|array
    {
        return match ($this) {
            self::U => ['IA', 'IO'],
            self::W => ['NG', 'ING'],
            self::P => ['S', 'Z'],
            self::D => ['C', 'K'],
            default => $this->toReversedLetter()
        };
    }

    public function toReversedSingleLetter(): string
    {
        return match ($this) {
            self::F => 'EA',
            self::U => '[IA|IO]',
            self::TH => 'Y',
            self::O => 'AE',
            self::R => 'A',
            self::C_OR_K => 'D',
            self::G => 'OE',
            self::W => '[NG|ING]',
            self::H => 'L',
            self::N => 'M',
            self::I => 'E',
            self::J => 'B',
            self::EO => 'T',
            self::P => '[S|Z]',
            self::X => 'X',
            self::S_OR_Z => 'P',
            self::T => 'EO',
            self::B => 'J',
            self::E => 'I',
            self::M => 'N',
            self::L => 'H',
            self::NG_OR_ING => 'W',
            self::OE => 'G',
            self::D => '[C|K]',
            self::A => 'R',
            self::AE => 'O',
            self::Y => 'TH',
            self::IA_OR_IO => 'U',
            self::EA => 'F',
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
        };
    }
}
