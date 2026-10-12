<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BruteforcePrimeCipherTest extends TestCase
{
    public function test_bruteforce_prime_cipher(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ ᚳᚦᚷᚹ ᚹᛚᚫ ᛉᚩᚪᛈ ᛗᛞᛞᚢᚷᚹ ᛚ ᛞᚾᚣᛄ ᚳᚠᛡ ᚫᛏᛈᛇᚪᚦ ᚳᚫ 3';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence, '--shift' => 1])
            ->expectsOutputToContain('Shift provided: 1')
            ->expectsOutputToContain('AN END WITHIN THE DEEP WEB THERE EXI[S|Z]T[S|Z] A PAGE THAT HA[S|Z]HE[S|Z] TO 3');
    }

    public function test_multiple_indexes_can_be_skipped(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence, 'indexesToSkip' => '0,1', '--shift' => 1])
            ->expectsOutputToContain('Indexes to skip: 0, 1')
            ->expectsOutputToContain('AEJ ')
            ->assertExitCode(0);
    }

    public function test_bruteforce_all_shifts(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ ᚳᚦᚷᚹ ᚹᛚᚫ ᛉᚩᚪᛈ ᛗᛞᛞᚢᚷᚹ ᛚ ᛞᚾᚣᛄ ᚳᚠᛡ ᚫᛏᛈᛇᚪᚦ ᚳᚫ 3';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence])
            ->expectsOutputToContain('No shift provided')
            ->expectsOutputToContain('| 1     | AN END WITHIN THE DEEP WEB')
            ->assertOk();
    }

    public function test_page_73_with_skipped_index(): void
    {
        $sentence = 'ᚫᛄ ᛟᛋᚱ ᛗᚣᛚᚩᚻ ᚩᚫ ᚳᚦᚷᚹ ᚹᛚᚫ ᛉᚩᚪᛈ ᛗᛞᛞᚢᚷᚹ ᛚ ᛞᚾᚣᛄ ᚳᚠᛡ ᚫᛏᛈᛇᚪᚦ ᚳᚫ 36367763ab73783c7af284446c59466b4cd653239a311cb7116d4618dee09a8425893dc7500b464fdaf1672d7bef5e891c6e2274568926a49fb4f45132c2a8b4 ᚳᛞ ᚠᚾ ᛡᛖ ᚠᚾᚳᛝ ᚱᚠ ᚫᛁᚱᛞᛖ ᛋᚣᛄᛠᚢᛝᚹ ᛉᚩ ᛗᛠᚹᚠ ᚱᚷᛡ ᛝᚱᛒ ᚫᚾᚢᛋ';

        $this->artisan('app:bruteforce-prime-cipher', ['sentence' => $sentence, 'indexesToSkip' => '202', '--shift' => 1])
            ->expectsOutputToContain('Indexes to skip: 202')
            ->expectsOutputToContain('AN END WITHIN THE DEEP WEB THERE EXI[S|Z]T[S|Z] A PAGE THAT HA[S|Z]HE[S|Z] TO 36367763ab73783c7af284446c59466b4cd653239a311cb7116d4618dee09a8425893dc7500b464fdaf1672d7bef5e891c6e2274568926a49fb4f45132c2a8b4 IT I[S|Z] THE DUTY OF EUERY PILGRIM TO [S|Z]EE[C|K] OUT THI[S|Z] PAGE')
            ->assertOk();
    }
}
