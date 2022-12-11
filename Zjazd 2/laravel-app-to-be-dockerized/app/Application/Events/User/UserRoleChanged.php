<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 11:27
 */

namespace App\Application\Events\User;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserRoleChanged extends ShouldBeStored
{
    public function __construct(private string $userId, private int $roleId)
    {

    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }
}
