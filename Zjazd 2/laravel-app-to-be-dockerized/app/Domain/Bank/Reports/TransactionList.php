<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 09:40
 */

namespace App\Domain\Bank\Reports;

use App\Domain\Bank\Reports\Dto\TransactionDto;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 *
 */
class TransactionList implements Arrayable, JsonSerializable
{
    /**
     * @var array
     */
    private array $transactions = [];

    /**
     * @param TransactionDto $dto
     */
    public function addTransaction(TransactionDto $dto): void
    {
        $this->transactions[] = $dto;
    }

    /**
     * @return array
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->transactions;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
