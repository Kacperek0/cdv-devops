<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 15:55
 */

namespace App\Domain\Bank\Reports\Decoders\Ipko\Excel;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

/**
 *
 */
class ImportCsv implements WithCustomCsvSettings
{
    use Importable;

    /**
     * @return string[]
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
}
