<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:10
 */

namespace App\Application\Events\User;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class PasswordForgotten extends ShouldBeStored
{
    /**
     * @param string $userId
     * @param string $email
     */
    public function __construct(private string $userId, private string $email){

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getMetaData(): array
    {
        return $this->metaData;
    }
}
