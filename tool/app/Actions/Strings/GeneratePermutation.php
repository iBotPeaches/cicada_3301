<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class GeneratePermutation
{
    public static array $permutations = [];

    public static function handle(string $pattern, int $index = 0, string $current = ''): void
    {
        if ($index == strlen($pattern)) {
            self::$permutations[] = $current;

            return;
        }

        if ($pattern[$index] != '[') {
            self::handle($pattern, $index + 1, $current.$pattern[$index]);
        } else {
            $closingIndex = strpos($pattern, ']', $index);
            $options = explode('|', substr($pattern, $index + 1, $closingIndex - $index - 1));

            foreach ($options as $option) {
                self::handle($pattern, $closingIndex + 1, $current.$option);
            }
        }
    }
}
