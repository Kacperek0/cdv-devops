<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 13:14
 */

namespace App\Domain\Bank\Reports\Strategies;

use App\Domain\Bank\Reports\Contracts\ReportDecoderContract;
use App\Domain\Bank\Reports\Contracts\ReportStrategyContract;
use App\Domain\Bank\Reports\Decoders\Ipko\CsvDecoder;
use App\Domain\Bank\Reports\Exceptions\ReportDecoderException;
use App\Domain\Bank\Reports\TransactionList;

/**
 *
 */
class IpkoStrategy implements ReportStrategyContract
{
    /**
     * @var array|string[]
     */
    protected array $decoders = [
        'csv' => CsvDecoder::class
    ];

    /**
     * @param string $data
     * @param string $format
     * @return array
     * @throws ReportDecoderException
     */
    public function decode(string $data, string $format): array
    {
        if (!$decoderClass = ($this->decoders[strtolower($format)] ?? null)) {
            throw new ReportDecoderException('Decoder not found');
        }

        /**
         * @var ReportDecoderContract $decoder
         */
        $decoder = app($decoderClass);
        return $decoder->decode($data);
    }

    /**
     * @return string[]
     */
    public function getAvailableDecoders(): array
    {
        return [
            'csv',
            'pdf',
            'xls',
            'xlsx',
            'json'
        ];
    }

    /**
     * @return array
     */
    public function getIgnored(): array
    {
        return [];
    }

    /**
     * @param array $data
     * @return TransactionList
     */
    public function getTransactions(array $data): TransactionList
    {
        return new TransactionList();
    }

    /**
     * @param TransactionList $transactions
     * @return array
     */
    public function getCategories(TransactionList $transactions): array
    {
        // TODO: Implement getCategories() method.
    }
}
