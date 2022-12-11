<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:44
 */

namespace App\Application\Aggregations\Expense;

use App\Application\Dto\Expense\ExpenseDto;
use App\Application\Events\Expense\ExpenseCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class ExpenseAggregate extends AggregateRoot
{
    /**
     * @param ExpenseDto $dto
     * @return $this
     */
    public function create(ExpenseDto $dto): self
    {
        $this->recordThat(
            new ExpenseCreated($dto)
        );

        return $this;
    }
}
