<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class RotationCipher
{
    public static string $letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';

    public static function handle(string $sentence, int $rotation): string
    {
        $rotation = $rotation % 26;
        if (! $rotation) {
            return $sentence;
        }
        if ($rotation < 0) {
            $rotation += 26;
        }
        if ($rotation == 13) {
            return str_rot13($sentence);
        }
        $rep = substr(self::$letters, $rotation * 2).substr(self::$letters, 0, $rotation * 2);

        return strtr($sentence, self::$letters, $rep);
    }
}
