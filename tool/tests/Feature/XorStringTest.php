<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class XorStringTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testXorString(string $data, string $key, string $expected): void
    {
        $this->artisan('app:xor-string')
            ->expectsQuestion('Enter a string to XOR', $data)
            ->expectsQuestion('Enter the key.', $key)
            ->assertOk()
            ->expectsOutputToContain($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'welcome' => [
                'ciphertext' => '5edb5e8029dd2182560da925ec6cd3e1257efc0b8328b4',
                'key' => '6ab768f540ad4ff1226fce429b06aa970b119262ec46be',
                'expected' => '4l6uipnstbggwjyv.onion',
            ],
        ];
    }
}
