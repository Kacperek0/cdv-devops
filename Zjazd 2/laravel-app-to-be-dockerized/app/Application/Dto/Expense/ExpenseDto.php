<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 08:58
 */

namespace App\Application\Dto\Expense;

use Carbon\Carbon;

/**
 *
 */
class ExpenseDto
{
    private ?array $data = null;
    private ?string $categoryId = null;

    /**
     * @param string $uuid
     * @param string $name
     * @param int $amount
     * @param string $userId
     * @param string $bankId
     * @param Carbon $date_at
     */
    public function __construct(
        private string $uuid,
        private string $name,
        private int $amount,
        private string $userId,
        private string $bankId,
        private Carbon $date_at
    ) {

    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
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
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * @param string|null $categoryId
     */
    public function setCategoryId(?string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getBankId(): string
    {
        return $this->bankId;
    }

    /**
     * @return Carbon
     */
    public function getDateAt(): Carbon
    {
        return $this->date_at;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }
}
