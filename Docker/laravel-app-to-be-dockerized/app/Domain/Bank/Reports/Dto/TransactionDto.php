<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 09:21
 */

namespace App\Domain\Bank\Reports\Dto;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 *
 */
class TransactionDto implements Arrayable, JsonSerializable
{
    /**
     * @param string $name
     * @param int $amount
     * @param string $category
     * @param Carbon $date
     */
    public function __construct(
        private string $name,
        private int $amount,
        private string $category,
        private Carbon $date
    ) {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'amount' => $this->getAmount(),
            'category' => $this->getCategory(),
            'date' => $this->getDate(),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
