<?php

declare(strict_types=1);

namespace App\Actions\Strings;

class GeneratePermutation
{
    public static function handle(string $pattern, int $index = 0, string $current = ''): \Generator
    {
        if ($index == strlen($pattern)) {
            yield $current;

            return;
        }

        if ($pattern[$index] != '[') {
            yield from self::handle($pattern, $index + 1, $current.$pattern[$index]);
        } else {
            $closingIndex = strpos($pattern, ']', $index);
            $options = explode('|', substr($pattern, $index + 1, $closingIndex - $index - 1));

            foreach ($options as $option) {
                yield from self::handle($pattern, $closingIndex + 1, $current.$option);
            }
        }
    }
}
