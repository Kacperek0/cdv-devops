<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 15:25
 */

namespace App\Application\Dto\User;

/**
 *
 */
class UserUpdateDto
{
    /**
     * @param string $userId
     * @param string $first_name
     * @param string $last_name
     */
    public function __construct(private string $userId, private string $first_name, private string $last_name)
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
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }
}
