<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Runes\TranslateSentence;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LiberPrimusReversedTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_sentence_reverse_decoding(string $runes, string $sentence): void
    {
        $this->assertSame($sentence, TranslateSentence::translate($runes, true));
    }

    public static function dataProvider(): array
    {
        return [
            // region 01.jpg
            '01.jpg - line 1' => [
                'runes' => 'ᚱ ᛝᚱᚪᛗᚹ ᛄᛁᚻᛖᛁᛡᛁ ᛗᚫᚣᚹ ᛠᚪᚫᚾ',
                'sentence' => 'A WARN[NG|ING] BELIEUE NOTH[NG|ING] FROM',
            ],
            '01.jpg - line 2' => [
                'runes' => 'ᚣᛖᛈ ᛄᚫᚫᛞᛁᛉᛞᛁᛋᛇ ᛝᛚᚱᛇ ᚦᚫᛡ',
                'sentence' => 'THI[S|Z] BOO[C|K]EX[C|K]EPT WHAT YOU',
            ],
            // endregion
        ];
    }
}
