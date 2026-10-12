<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TranslateVigenereTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_vigenere_decoding(string $ciphertext, string $key, string $indexes, string $expected): void
    {
        $this->artisan('app:vigenere')
            ->expectsQuestion('Enter a sentence to translate', $ciphertext)
            ->expectsQuestion('Enter the key.', $key)
            ->expectsQuestion('Enter the indexes to skip.', $indexes)
            ->assertOk()
            ->expectsOutputToContain($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'welcome' => [
                'ciphertext' => 'ᚢᛠᛝᛋᛇᚠᚳ ᚱᛇᚢᚷᛈᛠᛠ ᚠᚹᛉ',
                'key' => 'divinity',
                'indexes' => '',
                'expected' => 'WEL[C|K]OME',
            ],
            'page 04 - welcome pilgrim' => [
                'ciphertext' => 'ᚢᛠᛝᛋᛇᚠᚳ ᚱᛇᚢᚷᛈᛠᛠ ᚠᚹᛉᛏᚳᛚᛠ ᚣᛗ ᛠᛇ ᛏᚳᚾᚫ ᛝᛗᛡᛡᛗᛗᚹ ᚫᛈᛞᛝᛡᚱ ᚩᛠ ᛡᛗᛁ ᚠᚠ ᛖᚢᛝ ᛇᚢᚫ ᚣᛈ ᚱᚫ ᛁᛈᚫ ᚳᚫ ᚫᚾᚹ ᛒᛉᛗᛞ ᚱᛡᛁ ᚠᛈᚳ ᛇᛇᚫᚳ ᚱᚦᛈ ᚠᛄᛗᚩ ᛇᚳᚹᛡ ᛒᚫᚹ ᛒᛠᛚᛋ ᚱᚣ ᛄᚫ ᚱ ᛗᚳᚦᛇᚫᛏᚳᛈᚹ ᛗᚷᛇ ᚳᛝᛈᚢ ᛇᚳ ᚱᛖᚹ ᛡᛈᛁ ᛒᚣᛒᛉ ᚠᛚᛁᚱ ᚱᛗ ᚳᚷᛒ ᚣᚱ ᚳᚠᚢ ᚦᛈᛡᛄᚹᛏᚠᛠ ᛄᚷᛒ ᚫᚦᚠᚠᛠᛈᚦ ᛈᚠᚪᛉ ᛄᛗᛖᛈᛝᛋᚩᛋᛗ ᚹᛇᛄᛚ ᚹᛉᚢᚦᚫᚹᛗᚦ ᛞᚣᛄᚳ ᛋᛡᛉᚩᛝᚱᛗᛒᚹ ᚱᛗᛁ ᛞᚣᛄᚳ ᛉᚻᚢᚣᛈᛚ ᛄᛝᚣᛗᚠᛄᛈᛇᚢᛡ ᚹᛇᛄ ᛞᚹᛉᚢ ᚪᛚᚪᛋᛗᛡᛇᛉ ᚫᛗ ᛡᛗᛁ ᛈᚣ ᚫᛗᚢᚠ ᛗᚣ ᚣᛇ ᚫᛉᚱᛄᛋᛖ ᛖᚹᚾ ᛞᛄᚢᛋᛉᚣᛏᛖᛏᛗ ᛇᚱᚣ ᛞᛋ ᚾᛖᚫᛞᛡ ᛈᛒᚢᚾᛠᛝᛄᛡᚫ ᛄᚷᛒ ᛈᚦᛉ ᛈᚾᚹᚹᛁᛚᛗᚫ ᛚᛈᛒᚢᚩᛠᛡ ᚱᛡᛠᚠ ᚱᚱᛇᛄᛗ ᚱᛗᛁ ᛞᚣᛄ ᚻᛚᚠᚢ ᛄᚢᛡᛚᚦᛠ ᛇᛄᚩᛇᚱᚱᛗ ᚢᛗᛋᚳ ᛠᛇ ᛚᛁᚫᚫᚳᛚ ᚹᛁ ᛚᛏ ᛈᛖᚢᛈ ᛠᛡᛈᚦᛏᛒ ᛏᛗᛖ ᚢᛚᚩᛚᛖ ᛇᛄᛈ ᚢᛠ ᛚᚳᚷ ᛠᚷᛋᛡᛏᛗ ᛒᛗᚱᚦᚠᛈ ᚹᚱᛄ ᚱᛉᚳ ᛝ ᛄᛠᛟ ᛄᛖᚣᛗ ᛞᚣᛄᚳᚫᛡᚢᚠ ᛈᚠᚪ ᚳᚳᛠ ᚱ ᚢᛄᚱ ᚪᛗᛒᛈ ᚷᛈᛒᚢᚾᛠᛝᚠ ᚾᛉᛖ ᚣᚷᛁᛠᛝᚢᛗᛏᚳᚷᛠᛠ ᛄᚫ ᛒᛈᚹᛞ ᚠᚣᛉ ᚫᚢᚠ ᛇᛄᛈ ᛉᛚᚦᛠᚪ ᛚᚦ ᚳᚣᚢᛡ ᚳᛖ ᛚᚫᛇᛁᛉᚦᛋᚫᚻᚫ ᚦᚣᚠᛚᚳᛖᚱ ᛈᚠᚪᛉ ᚱᛒᛖ ᚫᚳᛒᚠ',
                'key' => 'divinity',
                'indexes' => '59, 95, 108, 170, 204, 205, 312, 523, 551, 578, 638',
                'expected' => 'WEL[C|K]OME WEL[C|K]OME PILGRIM TO THE GREAT JOURNEY TOWARD THE END OF ALL TH[NG|ING][S|Z] IT I[S|Z] NOT AN EA[S|Z]Y TRIP BUT FOR THO[S|Z]E WHO FIND THEIR WAY HERE IT I[S|Z] A NE[C|K]E[S|Z][S|Z]ARY ONE ALO[NG|ING] THE WAY YOU WILL FIND AN END TO ALL [S|Z]TRUGGLE AND [S|Z]UFFER[NG|ING] YOUR INNO[C|K]EN[C|K]E YOUR ILLU[S|Z][IA|IO]N[S|Z] YOUR [C|K]ERTAINTY AND YOUR REALITY ULTIMATELY YOU WILL DI[S|Z][C|K]OUER AN END TO [S|Z]ELF IT I[S|Z] THROUGH THI[S|Z] PILGRIMAGE THAT WE [S|Z]HAPE OUR[S|Z]ELUE[S|Z] AND OUR REALITIE[S|Z] JOURNEY DEEP WITHIN AND YOU WILL ARRIUE OUT[S|Z]IDE LI[C|K]E THE IN[S|Z]TAR IT I[S|Z] ONLY THROUGH GO[NG|ING] WITHIN THAT WE MAY EMERGE WID[S|Z]OM YOU ARE A BE[NG|ING] UNTO YOUR[S|Z]ELF YOU ARE A LAW UNTO YOUR[S|Z]ELF EA[C|K]H INTELLIGEN[C|K]E I[S|Z] HOLY FOR ALL THAT LIUE[S|Z] I[S|Z] HOLY AN IN[S|Z]TRU[C|K]T[IA|IO]N [C|K]OMMAND YOUR OWN [S|Z]ELF',
            ],
            'page 15 - koan' => [
                'ciphertext' => 'ᚪ ᛋᚹᚪᛁ ᛈᚢᛟᚫ ᛈ ᚠᛖᚱᛋᛈᛈ ᚦᛗ ᚾᚪᚱᛚᚹᛈ ᛖᚩᛈᚢᛠᛁᛁᚻᛞ ᛚᛟ ᛠ ᛄᛖ ᛠ ᛁᚫ ᚷᛖ ᚦᛟᛁᛞᛟ ᛝᚠ ᛄᛖ ᛞᛁᛉᚾᚢᛚᚠᚻᚱᚹᛈᛞᛡ ᚻᚹ ᛋᚳᛉᛞ ᚻᛡᛖᛡ ᛠᚱᛉᛖᛇ ᛒᚹ ᛠ ᛋᛒᛚᛞᚹᛈᚳ ᚫᚩ ᚹᛉᛞᚪᚪᛄᛠ ᚹᚣᛠᚳ ᛄᚪᚳ ᛗᚾᛈᛏ ᚩᚻ ᛗᛈᛗᚳᛡᚱ ᚱᚪᛚᛡ ᛁᛒ ᚠᛋ ᛈ ᚳᛝᛗᚳᚹ ᛁᛗᛗᛁᚪᚻ ᚣᛝᚳᛟ ᛒᛠᛇ ᛁ ᚱᚹᚾᛒ ᛡᚪᛗᛟ ᛈ ᛁᚩᛠᚳᛠ ᛉᚾ ᛚᛏ ᚻᛒᛡ ᛚᛇᚢᚪᚻᚣ ᚷᛖ ᛏᚷᚢᛇᛟᛡᚫ ᚪᛡᛞ ᛖᛟ ᚱᚫᚠᛋᚹᛡ ᚣᛗᛋ ᚣᚪᛗᛡ ᛏᚱ ᚷᛖᚾᚪ ᛚᛡ ᛗᛈᛋᚣᛟᚱ ᚩᚻ ᛗᛈᛗᚳᛡᚱ ᚱᛏᛈᛒ ᛈᛗᛈ ᚦᚹ ᛗᚳᛁᛞᚹᚾᚣ ᛠᚾᚪ ᚳᚪᛠᛡ ᛚᛡ ᚢᛝᛁᛋᛟ ᚦᚫᚷ ᛄᛗᛗᚳ ᚪᚪᛠᛞ ᚹᚹᚢ ᚾᛉᚢᚹ ᛈᛝ ᛁᚩᛠᚳᛠ ᛉᚾ ᛡᛟᚢᛟ ᛇᛒᚩ ᛁᚱ ᚦᛠ ᛉ ᚪᛁᛈ ᚦᚹ ᛗᚳᛁᛞᚹᚾᚣᛗ ᚹᛗᛞᛖ ᚹᛈᚾᛗᚷᚣᛏᛠᛈᛖᚪ',
                'key' => 'firfumferenfe',
                'indexes' => '65,76',
                'expected' => 'A [C|K]OAN DUR[NG|ING] A LE[S|Z][S|Z]ON THE MA[S|Z]TER EXPLAINED THE I THE I I[S|Z] THE UOI[C|K]E OF THE [C|K]IR[C|K]UMFEREN[C|K]E HE [S|Z]AID WHEN A[S|Z][C|K]ED BY A [S|Z]TUDENT TO EXPLAIN WHAT THAT MEANT THE MA[S|Z]TER [S|Z]AID IT I[S|Z] A UOI[C|K]E IN[S|Z]IDE YOUR HEAD I DONT HAUE A UOI[C|K]E IN MY HEAD THOUGHT THE [S|Z]TUDENT AND HE RAI[S|Z]ED HI[S|Z] HAND TO TELL THE MA[S|Z]TER THE MA[S|Z]TER [S|Z]TOP PED THE [S|Z]TUDENT AND [S|Z]AID THE UOI[C|K]E THAT JU[S|Z]T [S|Z]AID YOU HAUE NO UOI[C|K]E IN YOUR HEAD I[S|Z] THE I AND THE [S|Z]TUDENT[S|Z] WERE ENLIGHTENED',
            ],
        ];
    }
}
