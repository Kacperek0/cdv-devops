<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 15:47
 */

namespace App\Domain\Bank\Reports\Decoders\Ipko;

use App\Domain\Bank\Reports\Contracts\ReportDecoderContract;
use App\Domain\Bank\Reports\Decoders\Ipko\Excel\ImportCsv;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 *
 */
class CsvDecoder implements ReportDecoderContract
{
    /**
     * @param string $data
     * @return array
     * @throws JsonException
     */
    public function decode(string $data): array
    {
        $filename = sprintf('%s.csv', (string)Str::uuid());
        $tempFilepath = sprintf('temp/%s', $filename);

        Storage::put($tempFilepath, iconv('CP1250', 'UTF-8', $data));
        $result = (new ImportCsv())->toArray(Storage::path($tempFilepath));
        Storage::delete($tempFilepath);

        return $this->getRecords($result);
    }

    /**
     * @param array $result
     * @return array
     */
    protected function getRecords(array $result): array
    {
        print_r($result);
        exit();

        return array_values(array_filter(
            array_map(fn(array $record): array => $this->mapRecord($record), ($result[0] ?? [])),
            fn(array $record): bool => $this->isValid($record)
        ));
    }

    /**
     * @param array $record
     * @return array
     */
    protected function mapRecord(array $record): array
    {

        return [
            'date' => $record[1] ?? null,
            'description' => $record[1] ?? null,
            'category' => $record[3] ?? null,
            'amount' => $record[3] ?? null,
        ];
    }

    /**
     * @param array $record
     * @return bool
     */
    protected function isValid(array $record): bool
    {
        $validator = Validator::make($record, [
            'date' => [
                'required',
                'date'
            ],
            'description' => [
                'required'
            ],
            'category' => [
                'required'
            ],
            'amount' => [
                'required'
            ]
        ]);

        return !$validator->fails();
    }
}
