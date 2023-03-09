<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:02
 */

namespace App\Application\Events\User;

use App\Application\Dto\User\UserDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class UserCreated extends ShouldBeStored
{
    /**
     * @param UserDto $dto
     */
    public function __construct(private UserDto $dto)
    {

    }

    /**
     * @return UserDto
     */
    public function getDto(): UserDto
    {
        return $this->dto;
    }
}
