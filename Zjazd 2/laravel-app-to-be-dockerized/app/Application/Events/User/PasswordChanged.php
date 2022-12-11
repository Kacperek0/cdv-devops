<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 20:00
 */

namespace App\Application\Events\User;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class PasswordChanged extends ShouldBeStored
{
    /**
     * @param string $userId
     * @param string $password
     */
    public function __construct(private string $userId, private string $password)
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
