<?php

namespace App\Commands;

use App\Actions\Runes\TranslateSentence as TranslateSentenceAction;
use LaravelZero\Framework\Commands\Command;

class TranslateSentence extends Command
{
    protected $signature = 'app:translate-sentence';

    protected $description = 'Translate Sentence';

    public function handle(): int
    {
        $sentence = $this->ask('Enter a sentence to translate');
        $reversed = $this->ask('Reverse the translation? (y/n)', 'n');

        $this->output->write(TranslateSentenceAction::translate($sentence, $reversed === 'y').PHP_EOL);

        return self::SUCCESS;
    }
}
