<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 11:53
 */

namespace App\Domain\Bank\Reports;

use App\Domain\Bank\Reports\Dto\TransactionDto;

/**
 *
 */
class TransactionListModifier
{
    /**
     * @param TransactionList $transactionList
     * @return TransactionList
     */
    public static function getExpenses(TransactionList $transactionList): TransactionList
    {
        $newTransactionList = new TransactionList();

        $expenses = array_values(
            array_filter(
                $transactionList->getTransactions(),
                static fn(TransactionDto $dto): bool => $dto->getAmount() < 0
            )
        );

        foreach ($expenses as $expense) {
            $newTransactionList->addTransaction($expense);
        }

        return $newTransactionList;
    }

    /**
     * @param TransactionList $transactionList
     * @return TransactionList
     */
    public static function getIncomes(TransactionList $transactionList): TransactionList
    {
        $newTransactionList = new TransactionList();

        $expenses = array_values(
            array_filter(
                $transactionList->getTransactions(),
                static fn(TransactionDto $dto): bool => $dto->getAmount() > 0
            )
        );

        foreach ($expenses as $expense) {
            $newTransactionList->addTransaction($expense);
        }

        return $newTransactionList;
    }
}
