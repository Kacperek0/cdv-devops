<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 13:12
 */

namespace App\Domain\Bank\Reports\Strategies;

use App\Domain\Bank\Reports\Dto\TransactionDto;
use App\Domain\Bank\Reports\Contracts\ReportDecoderContract;
use App\Domain\Bank\Reports\Contracts\ReportStrategyContract;
use App\Domain\Bank\Reports\Decoders\Mbank\CsvDecoder;
use App\Domain\Bank\Reports\Decoders\Mbank\JsonDecoder;
use App\Domain\Bank\Reports\TransactionList;
use App\Domain\Bank\Reports\Exceptions\ReportDecoderException;
use App\Domain\Bank\Reports\ReportService;
use App\Domain\Bank\Reports\TransactionValidator;
use Carbon\Carbon;

/**
 *
 */
class MbankStrategy implements ReportStrategyContract
{
    /**
     * @var array|string[]
     */
    protected array $decoders = [
        'json' => JsonDecoder::class,
        'csv' => CsvDecoder::class
    ];

    /**
     * @var array|string[]
     */
    protected array $ignore = [
        'Przelew własny',
        'Księgowanie VAT'
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
     * @return array
     */
    public function getAvailableDecoders(): array
    {
        return array_keys($this->decoders);
    }

    /**
     * @return array
     */
    public function getIgnored(): array
    {
        return $this->ignore;
    }

    /**
     * @param TransactionList $transactions
     * @return array
     */
    public function getCategories(TransactionList $transactions): array
    {
        return array_values(
            array_unique(
                array_map(
                    static fn(TransactionDto $d): string => $d->getCategory(),
                    $transactions->getTransactions()
                )
            )
        );
    }

    /**
     * @param array $data
     * @return TransactionList
     */
    public function getTransactions(array $data): TransactionList
    {
        if ($this->isReportWithHeader($data)) {
            array_shift($data);
        }

        $validator = new TransactionValidator();

        $transactions = array_filter(
            $data,
            static fn(array $transaction): bool => $validator->validate($transaction)
        );

        $dto = new TransactionList();
        foreach ($transactions as $transaction) {
            if (in_array($transaction['category'], $this->getIgnored(), true)) {
                continue;
            }
            $dto->addTransaction(new TransactionDto(
                $transaction['description'],
                ReportService::parseAmount($transaction['amount']),
                $transaction['category'],
                Carbon::parse($transaction['date'])
            ));
        }

        return $dto;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function isReportWithHeader(array $data): bool
    {
        return ($data[0]['date'] ?? '') === '#Data operacji';
    }

}
