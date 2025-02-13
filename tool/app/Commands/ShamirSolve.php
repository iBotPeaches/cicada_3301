<?php

namespace App\Commands;

use App\Actions\Files\FileToHex;
use App\Actions\Strings\XorWords;
use App\Data\ShamirDataBlob;
use LaravelZero\Framework\Commands\Command;

class ShamirSolve extends Command
{
    protected $signature = 'app:shamir-solve';

    protected $description = 'Iterates the 2013 locations/data to extract secrets';

    public function handle(): int
    {
        // ISO Loading
        $iso = app_path('../../iso/unpacked/DATA');
        $dataFile13 = $iso.'/560.13';
        $dataFile17 = $iso.'/560.17';

        foreach ([$dataFile13, $dataFile17] as $file) {
            if (! file_exists($file)) {
                $this->error('Missing 2013 ISO file. Run `./scripts/download.iso.sh` in root of project.');

                return self::FAILURE;
            }
        }

        $files = [
            13 => FileToHex::handle($dataFile13),
            17 => FileToHex::handle($dataFile17),
        ];

        $tableHeader = ['DataSet', 'Offset', 'Data', 'Extracted', 'XORed'];
        $tableData = [];

        foreach ($this->getDataBlobs() as $blob) {
            $hexOffset = $blob->offset * 2;
            $hexLength = strlen($blob->data);
            $extractedData = substr($files[$blob->dataSetNumber], $hexOffset, $hexLength);

            $tableData[] = [
                'DataSet' => '560.'.$blob->dataSetNumber,
                'Offset' => $blob->offset,
                'Data' => $blob->data,
                'Extracted' => $extractedData,
                'XOR' => XorWords::handle($blob->data, $extractedData),
            ];
        }

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }

    private function getDataBlobs(): array
    {
        return [
            new ShamirDataBlob(17, 0x82B5, 'f6a2d0a48e1b1ae40cbd454f77baa7d2557683d0cd4998'), // Dallas, TX
            new ShamirDataBlob(13, 0x93E5, 'f286b8438cb85eb191ec7bf10a28a54ec06f9a27eb91c5'), // Okinawa, Japan
            new ShamirDataBlob(13, 0x10F447, 'c657b2707c4266fda4af4a83acf19cc46e69540c0bc5da'), // Moscow, Russia
            new ShamirDataBlob(13, 0x3607, '5edb5e8029dd2182560da925ec6cd3e1257efc0b8328b4'), // Little Rock, AR
            new ShamirDataBlob(17, 0x13099, 'd5a6cb76e55a2166bd6a4d078857ec1f68ea6afa9738'), // Annapolis, MD
            new ShamirDataBlob(13, 0x3215, '28c07e1b102d4d5c4c1a376e064477e1416fcc94928765'), // Portland, OR
            new ShamirDataBlob(17, 0x269, 'd4b10626d65995e8fb010f4388787d56433f90c6df8d8d'), // Columbus, GA
        ];
    }
}
