<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 08:58
 */

namespace App\Application\Events\Expense;

use App\Application\Dto\Expense\ExpenseDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class ExpenseCreated extends ShouldBeStored
{
    /**
     * @param ExpenseDto $dto
     */
    public function __construct(private ExpenseDto $dto)
    {

    }

    /**
     * @return ExpenseDto
     */
    public function getDto(): ExpenseDto
    {
        return $this->dto;
    }
}
