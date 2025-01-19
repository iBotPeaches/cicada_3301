<?php

declare(strict_types=1);

namespace App\Actions\Number;

class GetNextPrime
{
    public static function handle(?int $startingPrime = null): int
    {
        if (! $startingPrime) {
            $startingPrime = 1;
        }

        $currentPrime = gmp_nextprime($startingPrime);

        return gmp_intval($currentPrime);
    }
}
