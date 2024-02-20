<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class XorWords
{
    public static function handle(string $word, string $key): string
    {
        $binaryWord = ctype_xdigit($word) ? hex2bin($word) : $word;
        $binaryKey = ctype_xdigit($key) ? hex2bin($key) : $key;

        $size = min(strlen($binaryWord), strlen($binaryKey));
        $result = '';

        for ($i = 0; $i < $size; $i++) {
            $result .= $binaryWord[$i] ^ $binaryKey[$i];
        }

        return trim($result);
    }
}
