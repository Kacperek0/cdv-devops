<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 09:36
 */

namespace App\Application\Events\Role;

use App\Application\Dto\Role\RoleDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class RoleCreated extends ShouldBeStored
{
    /**
     * @param RoleDto $dto
     */
    public function __construct(private RoleDto $dto)
    {
    }

    /**
     * @return RoleDto
     */
    public function getDto(): RoleDto
    {
        return $this->dto;
    }

}
