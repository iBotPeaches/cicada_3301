<?php

declare(strict_types=1);

namespace App\Services\Docker;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class StegoToolkit
{
    public array $files = [];

    public function __construct(public string $imageId)
    {
        if (! $this->executeCommand('whoami')) {
            throw new \Exception('Failed to start shell in container');
        }
    }

    public function addFile(string $file): void
    {
        $this->files[] = $file;
    }

    public function mp3stego(string $password = 'abcd'): ?string
    {
        $commands = [
            'command' => 'mp3stego-decode',
            'decode' => '-X',
            'password' => '-P '.escapeshellarg($password),
            'in_file' => escapeshellarg('/tmp/'.basename($this->files[0])),
            'out_media' => '/tmp/out.pcm',
            'out_data' => '/tmp/out.txt',
            'suppression' => '> /dev/null 2>&1',
            'cat' => '&& cat /tmp/out.txt',
        ];

        return $this->executeCommand(implode(' ', $commands));
    }

    public function steghide(string $password = 'abcd'): ?string
    {
        $commands = [
            'command' => 'steghide',
            'extract' => 'extract',
            'extract_options' => '-sf '.escapeshellarg('/tmp/'.basename($this->files[0])),
            'password' => '-p '.escapeshellarg($password),
            'extract_to' => '-xf /tmp/out.txt',
            'suppression' => '> /dev/null 2>&1',
            'cat' => '&& cat /tmp/out.txt',
        ];

        return $this->executeCommand(implode(' ', $commands));
    }

    public function mp3stegoVersion(): ?string
    {
        $commands = [
            'command' => 'mp3stego-decode',
            'redirect' => '2>&1',
            'grep' => '| grep "MP3StegoEncoder"',
            'awk' => '| awk \'{print $2}\'',
        ];

        return $this->executeCommand(implode(' ', $commands));
    }

    public function steghideVersion(): ?string
    {
        $commands = [
            'command' => 'steghide',
            'version' => '--version',
        ];

        return $this->executeCommand(implode(' ', $commands));
    }

    private function executeCommand(string $command): ?string
    {
        $fileMounts = collect($this->files)->map(fn ($file) => '-v '.realpath($file).':/tmp/'.basename($file))->implode(' ');

        // Wrap command with sh -c to allow for multiple commands with proper interpretation
        $rawCommand = 'sh -c '.Str::wrap($command, '"', '"');
        $command = 'docker run '.$fileMounts.' '.$this->imageId.' '.$rawCommand;

        //echo $command.PHP_EOL;

        $result = Process::run($command);
        if ($result->exitCode() !== 0) {
            return null;
        }

        return Str::trim($result->output());
    }
}
