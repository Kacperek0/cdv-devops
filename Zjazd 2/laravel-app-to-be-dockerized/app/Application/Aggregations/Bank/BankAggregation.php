<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:53
 */

namespace App\Application\Aggregations\Bank;

use App\Application\Dto\Bank\BankDto;
use App\Application\Events\Bank\BankCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class BankAggregation extends AggregateRoot
{
    /**
     * @param BankDto $dto
     * @return $this
     */
    public function create(BankDto $dto): self
    {

        $this->recordThat(
            new BankCreated($dto)
        );

        return $this;
    }
}
