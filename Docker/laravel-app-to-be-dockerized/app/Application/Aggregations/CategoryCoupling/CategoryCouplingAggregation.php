<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 14:12
 */

namespace App\Application\Aggregations\CategoryCoupling;

use App\Application\Dto\CategoryCoupling\CategoryCouplingDto;
use App\Application\Events\CategoryCoupling\CategoryCouplingCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class CategoryCouplingAggregation extends AggregateRoot
{
    /**
     * @param CategoryCouplingDto $dto
     * @return $this
     */
    public function create(CategoryCouplingDto $dto): self
    {
        $this->recordThat(
            new CategoryCouplingCreated($dto)
        );

        return $this;
    }
}
