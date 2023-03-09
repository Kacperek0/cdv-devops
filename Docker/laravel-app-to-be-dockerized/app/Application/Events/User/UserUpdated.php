<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 15:25
 */

namespace App\Application\Events\User;

use App\Application\Dto\User\UserUpdateDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class UserUpdated extends ShouldBeStored
{
    /**
     * @param UserUpdateDto $dto
     */
    public function __construct(private UserUpdateDto $dto)
    {

    }

    /**
     * @return UserUpdateDto
     */
    public function getDto(): UserUpdateDto
    {
        return $this->dto;
    }
}
