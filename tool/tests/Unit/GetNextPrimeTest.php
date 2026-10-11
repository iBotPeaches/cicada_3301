<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Number\GetNextPrime;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GetNextPrimeTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_next_prime(?int $start, int $expected): void
    {
        $this->assertSame($expected, GetNextPrime::handle($start));
    }

    public static function dataProvider(): array
    {
        return [
            'null' => ['start' => null, 'expected' => 2],
            'zero' => ['start' => 0, 'expected' => 2],
            'from prime' => ['start' => 7, 'expected' => 11],
            'from composite' => ['start' => 100, 'expected' => 101],
        ];
    }
}
