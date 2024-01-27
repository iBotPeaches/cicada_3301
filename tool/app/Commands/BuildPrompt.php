<?php

namespace App\Commands;

use App\Enums\Rune;
use LaravelZero\Framework\Commands\Command;

class BuildPrompt extends Command
{
    protected $signature = 'app:build-prompt';

    protected $description = 'Build a Gematria Primus prompt for OpenAI';

    public function handle(): int
    {
        $prompt = <<<'PROMPT'
        Gematria Primus is a cipher that encodes the Latin alphabet into 24 runic characters.
        The alphabet was built for the Cicada 3301 challenge and not directly related to a specific Runic alphabet.
        However, the runic characters are similar to the Elder Futhark and Anglo-Saxon alphabets.
        The runic characters are then used to encode a message.
        The runic characters are as follows:

        As I give you images - please return the translation and only that.
        PROMPT;

        foreach (Rune::cases() as $rune) {
            $prompt .= "\nRune: {$rune->value} Letter: {$rune->toSingleLetter()} Number: {$rune->toInt()}";
        }

        $prompt .= PHP_EOL;

        $this->output->write($prompt);

        return self::SUCCESS;
    }
}
