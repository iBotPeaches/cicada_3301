<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Files\FileToHex;
use Tests\TestCase;

class FileToHexTest extends TestCase
{
    public function test_file_is_converted_to_hex(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'hex');
        file_put_contents($file, "AB\0");

        try {
            $this->assertSame('414200', FileToHex::handle($file));
        } finally {
            unlink($file);
        }
    }
}
