<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TranslateVigenereTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testVigenereTest(string $ciphertext, string $key, string $expected): void
    {
        $this->artisan('app:vigenere')
            ->expectsQuestion('Enter a sentence to translate', $ciphertext)
            ->expectsQuestion('Enter the key.', $key)
            ->assertOk()
            ->expectsOutputToContain($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'welcome' => [
                'ciphertext' => 'ᚢᛠᛝᛋᛇᚠᚳ ᚱᛇᚢᚷᛈᛠᛠ ᚠᚹᛉ',
                'key' => 'divinity',
                'expected' => 'WEL[C|K]OME',
            ],
        ];
    }
}
