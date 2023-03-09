<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:24
 */

namespace App\Application\Dto\User;

/**
 *
 */
class UserDto
{
    /**
     * @var string|null
     */
    private ?string $firstName = null;
    /**
     * @var string|null
     */
    private ?string $lastName = null;

    /**
     * @var int|null
     */
    private ?int $roleId = null;

    /**
     * @param string $uuid
     * @param string $email
     * @param string $password
     */
    public function __construct(private string $uuid, private string $email, private string $password)
    {

    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    /**
     * @param int|null $roleId
     */
    public function setRoleId(?int $roleId): void
    {
        $this->roleId = $roleId;
    }
}
