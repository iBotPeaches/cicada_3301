<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BuildPromptTest extends TestCase
{
    public function test_prompt_has_correct_rune_count(): void
    {
        $this->artisan('app:build-prompt')
            ->expectsOutputToContain('29 runic characters')
            ->assertExitCode(0);
    }
}
