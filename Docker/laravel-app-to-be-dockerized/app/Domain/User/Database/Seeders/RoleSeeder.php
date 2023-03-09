<?php
/**
 * User: gmatk
 * Date: 20.06.2022
 * Time: 21:03
 */

namespace App\Domain\User\Database\Seeders;

use App\Application\Repositories\RoleRepository;
use App\Application\Aggregations\Role\RoleAggregate;
use App\Application\Dto\Role\RoleDto;
use App\Application\Events\Role\RoleCreated;
use App\Domain\User\Entities\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 *
 */
class RoleSeeder extends Seeder
{
    /**
     * @var array|string[]
     */
    protected array $roles = [
        Role::DEFAULT_ROLE,
        Role::AMIN_ROLE
    ];
    /**
     * @var RoleRepository
     */
    private RoleRepository $repository;

    /**
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     */
    public function run(): void
    {
        if ($this->repository->count() > 0) {
            return;
        }

        foreach ($this->roles as $roleName) {
            RoleAggregate::retrieve((string)Str::uuid())
                ->create(new RoleDto($roleName))
                ->persist();
        }
    }
}
