<?php

declare(strict_types=1);

namespace App\Actions\Strings;

use Illuminate\Support\Str;

class SplitStringToEnglishRunePairs
{
    public static function handle(string $sentence): array
    {
        $pattern = '/(TH|EO|AE|NG|ING|IA|IO|EA|.)/';

        return preg_split($pattern, Str::upper($sentence), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }
}
