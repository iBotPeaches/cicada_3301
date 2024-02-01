<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ToRunicTest extends TestCase
{
    public function testStringToRunic(): void
    {
        $this->artisan('app:to-runic', ['sentence' => 'divinity'])
            ->expectsOutputToContain('ᛞ')
            ->assertExitCode(0);
    }
}
