<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\TranslateSentence;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LiberPrimusTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testSentenceDecoding(string $runes, string $sentence): void
    {
        $this->assertSame($sentence, TranslateSentence::translate($runes));
    }

    public static function dataProvider(): array
    {
        return [
            // region 01.jpg
            '01.jpg - line 1' => [
                'runes' => 'ᚱ ᛝᚱᚪᛗᚹ ᛄᛁᚻᛖᛁᛡᛁ ᛗᚫᚣᚹ ᛠᚪᚫᚾ',
                'sentence' => 'R [NG|ING]RAMW JIHEI[IA|IO]I MAEYW EAAAEN',
            ],
            '01.jpg - line 2' => [
                'runes' => 'ᚣᛖᛈ ᛄᚫᚫᛞᛁᛉᛞᛁᛋᛇ ᛝᛚᚱᛇ ᚦᚫᛡ',
                'sentence' => 'YEP JAEAEDIXDI[S|Z]EO [NG|ING]LREO THAE[IA|IO]',
            ],
            // endregion

            // region 05.jpg
            '05.jpg - line 1' => [
                'runes' => 'ᛋᚩᛗᛖ ᚹᛁᛋᛞᚩᛗ ᚦᛖ ᛈᚱᛁᛗᛖᛋ ᚪᚱᛖ ᛋᚪᚳ',
                'sentence' => '[S|Z]OME WI[S|Z]DOM THE PRIME[S|Z] ARE [S|Z]A[C|K]',
            ],

            // endregion
        ];
    }
}
