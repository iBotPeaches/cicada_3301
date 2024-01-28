<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class MidiSolveTest extends TestCase
{
    public function testMidiSolve(): void
    {
        $this->artisan('app:midi-solve')
            ->expectsOutputToContain('verygood')
            ->assertExitCode(0);
    }
}
