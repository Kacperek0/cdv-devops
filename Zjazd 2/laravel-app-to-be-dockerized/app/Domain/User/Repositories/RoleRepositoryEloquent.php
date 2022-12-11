<?php

namespace App\Domain\User\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\RoleRepository;
use App\Domain\User\Entities\Role;
use App\Application\Validators\RoleValidator;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Role::class;
    }

    /**
     * @return Role|null
     */
    public function getDefaultRole(): ?Role
    {
        return $this->findByField('name', Role::DEFAULT_ROLE)->first();
    }
}
