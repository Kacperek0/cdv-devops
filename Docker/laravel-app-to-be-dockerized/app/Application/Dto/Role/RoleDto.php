<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 10:17
 */

namespace App\Application\Dto\Role;

/**
 *
 */
class RoleDto
{
    /**
     * @var string|null
     */
    private ?string $guardName = null;

    /**
     * @param string $name
     */
    public function __construct(private string $name)
    {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getGuardName(): ?string
    {
        return $this->guardName;
    }

}
