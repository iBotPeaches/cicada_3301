<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Files\ParseWordlistsIntoArray;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ParseWordlistsIntoArrayTest extends TestCase
{
    private string $folder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->folder = sys_get_temp_dir().'/wordlists_'.uniqid();
        File::makeDirectory($this->folder);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->folder);

        parent::tearDown();
    }

    public function test_crlf_and_lf_wordlists_are_parsed(): void
    {
        File::put($this->folder.'/windows.txt', "foo\r\nbar\r\n");
        File::put($this->folder.'/unix.txt', "bar\nbaz\n");
        File::put($this->folder.'/ignored.md', "nope\n");

        $this->assertSame(['bar', 'baz', 'foo'], ParseWordlistsIntoArray::handle($this->folder));
    }
}
