<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class BruteforceAudioSteganographyTest extends TestCase
{
    public function test_fails_without_docker_image(): void
    {
        Process::fake(['docker images -q *' => Process::result('')]);

        $this->artisan('app:bruteforce-audio-steganography')
            ->expectsOutputToContain('Docker image not found')
            ->assertFailed();
    }

    public function test_fails_with_missing_audio_file(): void
    {
        Process::fake(['docker images -q *' => Process::result('img')]);

        $this->artisan('app:bruteforce-audio-steganography', ['file' => '/nonexistent/file.mp3'])
            ->expectsOutputToContain('Audio file not found: /nonexistent/file.mp3')
            ->assertFailed();
    }

    public function test_finds_secret_with_steghide(): void
    {
        Process::fake(function (PendingProcess $process) {
            $command = $process->command;

            return match (true) {
                str_starts_with($command, 'docker images') => Process::result('img'),
                str_contains($command, 'steghide extract') && str_contains($command, "-p 'divinity'") => Process::result('the secret'),
                str_contains($command, 'steghide extract'), str_contains($command, 'mp3stego-decode -X') => Process::result('', '', 1),
                default => Process::result('1.0'),
            };
        });

        $this->artisan('app:bruteforce-audio-steganography', ['file' => storage_path('steghide.wav')])
            ->expectsOutputToContain('SECRET FOUND! on word: "divinity" using tool: steghide.')
            ->expectsOutputToContain('the secret')
            ->assertOk();
    }

    public function test_finds_secret_with_mp3stego(): void
    {
        Process::fake(function (PendingProcess $process) {
            $command = $process->command;

            return match (true) {
                str_starts_with($command, 'docker images') => Process::result('img'),
                str_contains($command, 'mp3stego-decode -X') && str_contains($command, "-P 'welcome'") => Process::result('mp3 secret'),
                str_contains($command, 'steghide extract'), str_contains($command, 'mp3stego-decode -X') => Process::result('', '', 1),
                default => Process::result('1.0'),
            };
        });

        $this->artisan('app:bruteforce-audio-steganography', ['file' => storage_path('mp3stego.mp3')])
            ->expectsOutputToContain('SECRET FOUND! on word: "welcome" using tool: mp3stego.')
            ->expectsOutputToContain('mp3 secret')
            ->assertOk();
    }
}
