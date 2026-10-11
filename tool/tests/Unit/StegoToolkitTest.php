<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Docker\StegoToolkit;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class StegoToolkitTest extends TestCase
{
    public function test_constructor_throws_when_container_fails(): void
    {
        Process::fake(['*' => Process::result('', 'no such image', 125)]);

        $this->expectExceptionMessage('Failed to start shell in container');

        new StegoToolkit('img');
    }

    public function test_files_are_mounted_and_password_is_escaped(): void
    {
        Process::fake(['*' => Process::result('secret')]);
        $file = storage_path('steghide.wav');

        $toolkit = new StegoToolkit('img');
        $toolkit->addFile($file);

        $this->assertSame('secret', $toolkit->steghide("it's"));

        Process::assertRan(function (PendingProcess $process) use ($file) {
            return str_contains($process->command, '-v '.realpath($file).':/tmp/steghide.wav img')
                && str_contains($process->command, '-p '.escapeshellarg("it's"));
        });
    }

    public function test_failed_extraction_returns_null(): void
    {
        Process::fake(function (PendingProcess $process) {
            return str_contains($process->command, 'mp3stego-decode')
                ? Process::result('', 'bad password', 1)
                : Process::result('root');
        });

        $toolkit = new StegoToolkit('img');
        $toolkit->addFile(storage_path('mp3stego.mp3'));

        $this->assertNull($toolkit->mp3stego('wrong'));
    }
}
