<?php

namespace App\Commands;

use App\Actions\Files\FileToHex;
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
        $dataFile13 = $iso . '/560.13';
        if (!file_exists($dataFile13)) {
            $this->error('Missing 2013 ISO file. Run `./scripts/download.iso.sh` in root of project.');
            return self::FAILURE;
        }

        $data = FileToHex::handle($dataFile13);

        $tableHeader = ['DataSet', 'Offset', 'Data', 'Extracted'];
        $tableData = [];

        foreach ($this->getDataBlobs() as $blob) {
            $hexOffset = $blob->offset * 2;
            $hexLength = strlen($blob->data);
            $extractedData = substr($data, $hexOffset, $hexLength);

            $tableData[] = [
                'DataSet' => '560.' . $blob->dataSetNumber,
                'Offset' => $blob->offset,
                'Data' => $blob->data,
                'Extracted' => $extractedData,
            ];
        }

        $this->table($tableHeader, $tableData);

        return self::SUCCESS;
    }

    private function getDataBlobs(): array
    {
        return [
            new ShamirDataBlob(13, 0x3607, '5edb5e8029dd2182560da925ec6cd3e1257efc0b8328b4'),
        ];
    }
}
