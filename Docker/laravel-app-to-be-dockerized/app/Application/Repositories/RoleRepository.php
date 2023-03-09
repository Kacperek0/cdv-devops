<?php

namespace App\Application\Repositories;

use App\Domain\User\Entities\Role;
use App\Infrastructure\Interfaces\RepositoryInterface;

/**
 * Interface RoleRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface RoleRepository extends RepositoryInterface
{
    /**
     * @return Role|null
     */
    public function getDefaultRole(): ?Role;
}
