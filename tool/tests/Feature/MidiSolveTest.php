<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class MidiSolveTest extends TestCase
{
    public function test_midi_solve(): void
    {
        $this->artisan('app:midi-solve')
            ->expectsOutputToContain('verygood')
            ->assertExitCode(0);
    }
}
