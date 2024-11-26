<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BruteforceColumnKeyTest extends TestCase
{
    public function test_bruteforce_column_key(): void
    {
        $sentence = 'TL BE IE OV UT HT RE ID TS EO ST PO SO YR SL BT II IY T4 DG UQ IM NU 44 2I 15 33 9M';

        $this->artisan('app:bruteforce-column-key')
            ->expectsQuestion('Enter a sentence to bruteforce', $sentence)
            ->expectsTable(['Key (4)', 'Plaintext'], [])
            ->expectsTable(['Key (7)', 'Plaintext'], [
                ['0623145', 'TOBELIEVETHUTRISTSDEOTROSPOYSIBTLIIYQ4DTGUI2NUM44IM53139'],
                ['0625143', 'TOBELIEVETRUTHISTODESTROYPOSSIBILITYQ4UTGDI2N4M4UIM59133'],
            ])
            ->assertExitCode(0);
    }
}
