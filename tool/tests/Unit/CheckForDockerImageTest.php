<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Process\CheckForDockerImage;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class CheckForDockerImageTest extends TestCase
{
    public function test_image_id_is_returned(): void
    {
        Process::fake(['docker images -q *' => Process::result("abc123\n")]);

        $this->assertSame('abc123', CheckForDockerImage::handle('some/image'));
    }

    public function test_missing_image_returns_empty_string(): void
    {
        Process::fake(['docker images -q *' => Process::result('')]);

        $this->assertSame('', CheckForDockerImage::handle('some/image'));
    }

    public function test_docker_failure_returns_null(): void
    {
        Process::fake(['docker images -q *' => Process::result('', 'daemon not running', 1)]);

        $this->assertNull(CheckForDockerImage::handle('some/image'));
    }
}
