<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:43
 */

namespace App\Application\Aggregations\User;

use App\Application\Dto\User\UserDto;
use App\Application\Events\User\UserCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 *
 */
class UserAggregate extends AggregateRoot
{
    /**
     * @param UserDto $dto
     * @return $this
     */
    public function create(UserDto $dto): self
    {
        $this->recordThat(
            new UserCreated($dto)
        );

        return $this;
    }
}
