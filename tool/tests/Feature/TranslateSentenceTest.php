<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TranslateSentenceTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testSentenceDecoding(string $ciphertext, string $expected): void
    {
        $this->artisan('app:translate')
            ->expectsQuestion('Enter a sentence to translate', $ciphertext)
            ->assertOk()
            ->expectsOutputToContain($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'welcome' => [
                'ciphertext' => 'ᚱ ᛝᚱᚪᛗᚹ ᛄᛁᚻᛖᛁᛡᛁ ᛗᚫᚣᚹ ᛠᚪᚫᚾ',
                'expected' => 'A WARN[NG|ING] BELIEUE NOTH[NG|ING] FROM',
            ],
        ];
    }
}
