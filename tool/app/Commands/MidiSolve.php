<?php

namespace App\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use League\Csv\Reader;

class MidiSolve extends Command
{
    protected $signature = 'app:midi-solve';

    protected $description = 'Extracts information from (song.csv) in storage';

    public function handle(): int
    {
        $chorus = <<<'TEXT'
            Let the Priests of the Raven of dawn, no longer in deadly black, with hoarse note curse the sons of joy. Nor his accepted brethren, whom tyrant, he calls free: lay the bound or build the roof. Nor pale religious letchery call that virginity, that wishes but acts not!
            For every thing that lives is Holy.
        TEXT;

        // Only keep the alphabet
        $chorus = Str::lower(preg_replace('/[^A-Za-z]/', '', $chorus));

        $midiFilePath = storage_path('song.csv');
        $csv = Reader::createFromPath($midiFilePath, 'r');
        [$track1, $track2, $track3, $track4] = collect($csv->getRecords())->groupBy('0');

        $mapping = [];
        $index = 0;
        $onNoteCache = [];
        $usedLetters = [];

        $track4 = $track4->filter(function (array $record): bool {
            $key = trim(Arr::get($record, '2'));

            return $key === 'Note_off_c' || $key === 'Note_on_c';
        })->each(function (array $record) use (&$onNoteCache, &$mapping, &$index, &$usedLetters, $chorus) {
            $key = trim(Arr::get($record, '2'));

            // Store this note for the next "off" event.
            if ($key === 'Note_on_c') {
                $onNoteCache = $record;

                return;
            }

            $length = Arr::get($record, '1') - Arr::get($onNoteCache, '1');
            $mappingKey = trim(Arr::get($record, '4').'-'.$length);

            if (! Arr::has($mapping, $mappingKey)) {
                $character = $chorus[$index++];
                while (in_array($character, $usedLetters)) {
                    $character = $chorus[$index++];
                }

                $usedLetters[] = $character;
                $mapping[$mappingKey] = $character ?? null;
            }
        });

        $decodedMessage = '';
        $track3 = $track3->filter(function (array $record): bool {
            $key = trim(Arr::get($record, '2'));

            return $key === 'Note_off_c' || $key === 'Note_on_c';
        })->each(function (array $record) use (&$onNoteCache, &$mapping, &$decodedMessage) {
            $key = trim(Arr::get($record, '2'));

            // Store this note for the next "off" event.
            if ($key === 'Note_on_c') {
                $onNoteCache = $record;

                return;
            }

            $length = Arr::get($record, '1') - Arr::get($onNoteCache, '1');
            $mappingKey = trim((Arr::get($record, '4') - 12).'-'.$length);

            if (Arr::has($mapping, $mappingKey)) {
                $decodedMessage .= $mapping[$mappingKey];
            } else {
                $decodedMessage .= "[{$mappingKey}]";
            }
        });

        $this->info($decodedMessage);

        return self::SUCCESS;
    }
}
