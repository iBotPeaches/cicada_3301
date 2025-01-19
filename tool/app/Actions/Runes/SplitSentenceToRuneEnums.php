<?php

declare(strict_types=1);

namespace App\Actions\Runes;

use App\Enums\Rune;
use Illuminate\Support\Collection;

class SplitSentenceToRuneEnums
{
    /** @return Collection<Rune|string> */
    public static function handle(string $sentence): Collection
    {
        return collect(mb_str_split($sentence))
            ->map(fn (string $rune) => Rune::tryFrom($rune) ?? $rune);
    }
}
