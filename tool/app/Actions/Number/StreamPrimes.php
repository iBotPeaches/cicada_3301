<?php

declare(strict_types=1);

namespace App\Actions\Number;

class StreamPrimes
{
    public static function handle(?int $startingPrime): \Generator
    {
        if (! $startingPrime) {
            $startingPrime = 1;
        }

        $currentPrime = gmp_nextprime($startingPrime);

        while (true) {
            yield $currentPrime;
            $currentPrime = gmp_nextprime($currentPrime);
        }
    }
}
