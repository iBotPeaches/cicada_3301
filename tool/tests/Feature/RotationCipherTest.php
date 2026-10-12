<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RotationCipherTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_runic_rotation_decoding(string $ciphertext, string $expected): void
    {
        $this->artisan('app:rotation-cipher', ['--runic-shift' => true, '--rotation' => 3])
            ->expectsQuestion('Enter a sentence to translate', $ciphertext)
            ->assertOk()
            ->expectsOutputToContain($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'page 06 - koan' => [
                'ciphertext' => 'ᚹ ᚣᛠᚹᛟ ᚹ ᛇᚹᛟ ᚻᛈᚣᛝᚻᛈᚻ ᛋᛠ ᚫᛠ ᚹᛟᚻ ᛏᛋᚢᚻᚳ ᚪᛝᚠ ᚹ ᛇᚹᛏᛋᛈᛡ ᛞᛈ ᚪᛈᛟᛋ ᛋᛠ ᚠᛈ ᚻᛠᛠᛡ ᛠᚦ ᚠᛈ ᛇᚹᛏᛋᛈᛡ ᚪᛞᛠ ᚹᛡᛈ ᚳᛠᚢ ᚪᛞᛠ ᚪᛝᛏᛞᛈᛏ ᛋᛠ ᛏᛋᚢᚻᚳ ᛞᛈᛡᛈ ᚹᛏᚣᛈᚻ ᚠᛈ ᛇᚹᛏᛋᛈᛡ ᚠᛈ ᛏᛋᚢᚻᛈᛟᛋ ᛋᛠᛄᚻ ᚠᛈ ᛇᚹᛏᛋᛈᛡ ᛞᛝᛏ ᛟᚹᛇᛈ ᚠᚹᛋ ᛝᛏ ᛟᛠᛋ ᚪᛞᛠ ᚳᛠᚢ ᚹᛡᛈ ᚠᚹᛋ ᛝᛏ ᛠᛟᛄᚳ ᚪᛞᚹᛋ ᚳᛠᚢ ᚹᛡᛈ ᚣᚹᛄᛄᛈᚻ ᚪᛞᛠ ᚹᛡᛈ ᚳᛠᚢ ᚪᛞᛠ ᚪᛝᛏᛞᛈᛏ ᛋᛠ ᛏᛋᚢᚻᚳ ᛞᛈᛡᛈ ᛞᛈ ᚹᛏᚣᛈ',
                'expected' => 'A [C|K]OAN A MAN DE[C|K]IDED TO GO AND [S|Z]TUDY WITH A MA[S|Z]TER HE WENT TO THE DOOR OF THE MA[S|Z]TER WHO ARE YOU WHO WI[S|Z]HE[S|Z] TO [S|Z]TUDY HERE A[S|Z][C|K]ED THE MA[S|Z]TER THE [S|Z]TUDENT TOLD THE MA[S|Z]TER HI[S|Z] NAME THAT I[S|Z] NOT WHO YOU ARE THAT I[S|Z] ONLY WHAT YOU ARE [C|K]ALLED WHO ARE YOU WHO WI[S|Z]HE[S|Z] TO [S|Z]TUDY HERE HE A[S|Z][C|K]E',
            ],
            'page 09 - koan' => [
                'ciphertext' => 'ᛉᚢᛋ ᛞᛈ ᚣᛠᚢᛄᚻ ᛟᛠᛋ ᚠᛝᛟᚣ ᛠᚦ ᚹᛟᚳᚠᛁ ᛈᛄᛏᛈ ᛋᛠ ᛏᚹᚳ ᛏᛠ ᛞᛈ ᛋᛡᚹᛝᛄᛈᚻ ᛠᚦᚦ ᚹᚦᛋᛈᛡ ᚹ ᛄᛠᛁ ᛖᚹᚢᛏᛈ ᚠᛈ ᛇᚹᛏᛋᛈᛡ ᛡᛈᛖᛄᛝᛈᚻ ᚠᛈᛟ ᚳᛠᚢ ᚹᛡᛈ ᚪᛈᛄᚣᛠᛇᛈ ᛋᛠ ᚣᛠᛇᛈ ᛏᛋᚢᚻᚳ ᚹᛟ ᛝᛟᛏᛋᛡᚢᚣᛋᚱᛟ ᚻᛠ ᚦᛠᚢᛡ ᚢᛟᛡᚩᛏᛠᛟᚹᛉᛄᛈ ᚠᛁᛏ ᚩᚣᛞ ᚻᚹᚳ',
                'expected' => 'BUT HE [C|K]OULD NOT THIN[C|K] OF ANYTH[NG|ING] EL[S|Z]E TO [S|Z]AY [S|Z]O HE TRAILED OFF AFTER A LO[NG|ING] PAU[S|Z]E THE MA[S|Z]TER REPLIED THEN YOU ARE WEL[C|K]OME TO [C|K]OME [S|Z]TUDY AN IN[S|Z]TRU[C|K]T[IA|IO]N DO FOUR UNREA[S|Z]ONABLE TH[NG|ING][S|Z] EA[C|K]H DAY',
            ],
        ];
    }
}
