<?php

declare(strict_types=1);

namespace App\Data;

readonly class ShamirDataBlob
{
    public function __construct(
        public int $dataSetNumber,
        public int $offset,
        public string $data,
    ) {
        //
    }
}
