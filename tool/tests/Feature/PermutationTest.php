<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PermutationTest extends TestCase
{
    public function test_permutation_on_string(): void
    {
        $this->artisan('app:permutation', ['sentence' => 'A WARN[NG|ING] BELIEUE NOTH[NG|ING] FROM'])
            ->expectsOutputToContain('A WARNNG BELIEUE NOTHNG FROM')
            ->expectsOutputToContain('A WARNNG BELIEUE NOTHING FROM')
            ->expectsOutputToContain('A WARNING BELIEUE NOTHNG FROM')
            ->expectsOutputToContain('A WARNING BELIEUE NOTHING FROM')
            ->assertExitCode(0);
    }
}
