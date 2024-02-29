<?php

declare(strict_types=1);

namespace App\Actions\Arrays;

use Illuminate\Support\Arr;

class GeneratePermutation
{
    public static function handle(array $item): \Generator
    {
        if (count($item) <= 1) {
            yield $item;
        }

        foreach ($item as $key => $value) {
            $sub = $item;
            unset($sub[$key]);

            foreach (self::handle($sub) as $permutation) {
                yield array_merge(Arr::wrap($value), $permutation);
            }
        }
    }
}
