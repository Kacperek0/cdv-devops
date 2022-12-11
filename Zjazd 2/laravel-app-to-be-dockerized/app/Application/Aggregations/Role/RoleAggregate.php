<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:44
 */

namespace App\Application\Aggregations\Role;

use App\Application\Dto\Role\RoleDto;
use App\Application\Events\Role\RoleCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class RoleAggregate extends AggregateRoot
{
    /**
     * @param RoleDto $dto
     * @return $this
     */
    public function create(RoleDto $dto): self
    {
        $this->recordThat(
            new RoleCreated($dto)
        );

        return $this;
    }
}
