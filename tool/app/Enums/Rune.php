<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Str;

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

    public static function tryFromEnglish(string $letters): ?Rune
    {
        return match ($letters) {
            'F' => self::F,
            'U', 'V' => self::U,
            'TH' => self::TH,
            'O' => self::O,
            'R' => self::R,
            'C', 'K' => self::C_OR_K,
            'G' => self::G,
            'W' => self::W,
            'H' => self::H,
            'N' => self::N,
            'I' => self::I,
            'J' => self::J,
            'EO' => self::EO,
            'P' => self::P,
            'X' => self::X,
            'S', 'Z' => self::S_OR_Z,
            'T' => self::T,
            'B' => self::B,
            'E' => self::E,
            'M' => self::M,
            'L' => self::L,
            'NG', 'ING' => self::NG_OR_ING,
            'OE' => self::OE,
            'D' => self::D,
            'A' => self::A,
            'AE' => self::AE,
            'Y' => self::Y,
            'IA', 'IO' => self::IA_OR_IO,
            'EA' => self::EA,
            default => null,
        };
    }

    public static function tryFromIndex(int $index): ?Rune
    {
        return match ($index) {
            0 => self::F,
            1 => self::U,
            2 => self::TH,
            3 => self::O,
            4 => self::R,
            5 => self::C_OR_K,
            6 => self::G,
            7 => self::W,
            8 => self::H,
            9 => self::N,
            10 => self::I,
            11 => self::J,
            12 => self::EO,
            13 => self::P,
            14 => self::X,
            15 => self::S_OR_Z,
            16 => self::T,
            17 => self::B,
            18 => self::E,
            19 => self::M,
            20 => self::L,
            21 => self::NG_OR_ING,
            22 => self::OE,
            23 => self::D,
            24 => self::A,
            25 => self::AE,
            26 => self::Y,
            27 => self::IA_OR_IO,
            28 => self::EA,
            default => null,
        };
    }

    public function toNumericPosition(): int
    {
        return match ($this) {
            self::F => 0,
            self::U => 1,
            self::TH => 2,
            self::O => 3,
            self::R => 4,
            self::C_OR_K => 5,
            self::G => 6,
            self::W => 7,
            self::H => 8,
            self::N => 9,
            self::I => 10,
            self::J => 11,
            self::EO => 12,
            self::P => 13,
            self::X => 14,
            self::S_OR_Z => 15,
            self::T => 16,
            self::B => 17,
            self::E => 18,
            self::M => 19,
            self::L => 20,
            self::NG_OR_ING => 21,
            self::OE => 22,
            self::D => 23,
            self::A => 24,
            self::AE => 25,
            self::Y => 26,
            self::IA_OR_IO => 27,
            self::EA => 28,
        };
    }

    public function toReversedNumericPosition(): int
    {
        return (count(self::cases()) - 1) - $this->toNumericPosition();
    }

    public function toUnicode(): string
    {
        return Str::upper(dechex(mb_ord($this->toRune())));
    }

    public function toRune(): string
    {
        return $this->value;
    }
}
