<?php

namespace App\Commands;

use App\Actions\Files\FilterWordlists;
use App\Actions\Process\CheckForDockerImage;
use App\Services\Docker\StegoToolkit;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class BruteforceAudioSteganography extends Command
{
    protected $signature = 'app:bruteforce-audio-steganography {file?}';

    protected $description = 'Attempts to bruteforce audio file using stego-toolkit.';

    public function handle(): int
    {
        $dockerImage = 'dominicbreuker/stego-toolkit';
        $imageId = CheckForDockerImage::handle($dockerImage);
        $audioFile = $this->argument('file') ?? storage_path('mp3stego.mp3');

        if (! $imageId) {
            $this->error('Docker image not found. Please run `docker pull dominicbreuker/stego-toolkit`.');

            return self::FAILURE;
        }

        if (! File::exists($audioFile)) {
            $this->error('Audio file not found: '.$audioFile);

            return self::FAILURE;
        }

        $wordlistFolder = app_path('../../wordlists');
        $wordlists = FilterWordlists::handle($wordlistFolder, 1);
        $stegoToolkit = new StegoToolkit($imageId);
        $stegoToolkit->addFile($audioFile);
        $this->info('Attempting to bruteforce audio file using stego-toolkit...');
        $this->info($stegoToolkit->mp3stegoVersion());

        foreach ($wordlists as $word) {
            $secret = $stegoToolkit->mp3stego($word);

            if (is_string($secret)) {
                $this->output->success('SECRET FOUND! on word: '.Str::wrap($word, '"', '"').' using tool: mp3stego.');
                $this->info($secret);
                break;
            }
        }

        return self::SUCCESS;
    }
}
