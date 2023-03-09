<?php

namespace App\Domain\User\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\PermissionRepository;
use App\Domain\User\Entities\Permission;
use App\Application\Validators\PermissionValidator;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }
}
