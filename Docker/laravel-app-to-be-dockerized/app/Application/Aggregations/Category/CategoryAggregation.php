<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:30
 */

namespace App\Application\Aggregations\Category;

use App\Application\Dto\Category\CategoryDto;
use App\Application\Events\Category\CategoryCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class CategoryAggregation extends AggregateRoot
{
    /**
     * @param CategoryDto $dto
     * @return $this
     */
    public function create(CategoryDto $dto): self
    {
        $this->recordThat(
            new CategoryCreated($dto)
        );

        return $this;
    }
}
