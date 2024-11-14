<?php

namespace App\Commands;

use App\Actions\Process\CheckForDockerImage;
use App\Services\Docker\StegoToolkit;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class BruteforceAudioSteganography extends Command
{
    protected $signature = 'app:bruteforce-audio-steganography {file?}';

    protected $description = 'Attempts to bruteforce audio file using stego-toolkit.';

    public function handle(): int
    {
        $dockerImage = 'dominicbreuker/stego-toolkit';
        $containerId = CheckForDockerImage::handle($dockerImage);
        $audioFile = $this->argument('file') ?? storage_path('interconnected.mp3');

        if (! $containerId) {
            $this->error('Docker image not found. Please run `docker pull dominicbreuker/stego-toolkit`.');

            return self::FAILURE;
        }

        if (! File::exists($audioFile)) {
            $this->error('Audio file not found: '.$audioFile);

            return self::FAILURE;
        }

        $stegoToolkit = new StegoToolkit($containerId);

        return self::SUCCESS;
    }
}
