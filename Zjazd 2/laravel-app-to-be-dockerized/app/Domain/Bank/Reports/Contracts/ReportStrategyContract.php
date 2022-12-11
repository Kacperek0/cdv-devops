<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 13:12
 */

namespace App\Domain\Bank\Reports\Contracts;

use App\Domain\Bank\Reports\TransactionList;

/**
 *
 */
interface ReportStrategyContract
{
    /**
     * @param string $data
     * @param string $format
     * @return array
     */
    public function decode(string $data,  string $format): array;

    /**
     * @return array
     */
    public function getAvailableDecoders(): array;

    /**
     * @return array
     */
    public function getIgnored(): array;

    /**
     * @param array $data
     * @return TransactionList
     */
    public function getTransactions(array $data): TransactionList;

    /**
     * @param TransactionList $transactions
     * @return array
     */
    public function getCategories(TransactionList $transactions): array;
}
