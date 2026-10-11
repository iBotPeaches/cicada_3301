<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class XorWords
{
    public static function handle(string $word, string $key): string
    {
        $binaryWord = self::isHex($word) ? hex2bin($word) : $word;
        $binaryKey = self::isHex($key) ? hex2bin($key) : $key;

        $size = min(strlen($binaryWord), strlen($binaryKey));
        $result = '';

        for ($i = 0; $i < $size; $i++) {
            $result .= $binaryWord[$i] ^ $binaryKey[$i];
        }

        return $result;
    }

    private static function isHex(string $value): bool
    {
        return ctype_xdigit($value) && strlen($value) % 2 === 0;
    }
}
