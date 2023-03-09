<?php
/**
 * User: gmatk
 * Date: 20.06.2022
 * Time: 20:36
 */

namespace App\Domain\User\Providers;

use App\Application\Repositories\ExpenseRepository;
use App\Application\Repositories\PermissionRepository;
use App\Application\Repositories\RoleRepository;
use App\Application\Repositories\UserRepository;
use App\Application\Services\Expense\ExpenseServiceContract;
use App\Domain\User\Console\Commands\UserCreateCommand;
use App\Domain\User\Projectors\ExpenseProjector;
use App\Domain\User\Projectors\RoleProjector;
use App\Domain\User\Projectors\UserProjector;
use App\Domain\User\Reactors\UserReactor;
use App\Domain\User\Repositories\ExpenseRepositoryEloquent;
use App\Domain\User\Repositories\PermissionRepositoryEloquent;
use App\Domain\User\Repositories\RoleRepositoryEloquent;
use App\Domain\User\Repositories\UserRepositoryEloquent;
use App\Domain\User\Services\ExpenseService;
use App\Infrastructure\Abstracts\BaseDomainServiceProvider;

/**
 *
 */
class DomainServiceProvider extends BaseDomainServiceProvider
{
    /**
     * @var string
     */
    protected string $alias = 'user';
    /**
     * @var bool
     */
    protected bool $hasMigrations = true;

    /**
     * @var array|string[]
     */
    protected array $providers = [
        RouteServiceProvider::class,
        AuthServiceProvider::class
    ];

    /**
     * @var array|string[]
     */
    protected array $domainBindings = [
        UserRepository::class => UserRepositoryEloquent::class,
        RoleRepository::class => RoleRepositoryEloquent::class,
        PermissionRepository::class => PermissionRepositoryEloquent::class,
        ExpenseRepository::class => ExpenseRepositoryEloquent::class,
        ExpenseServiceContract::class => ExpenseService::class
    ];

    /**
     * @var array|string[]
     */
    protected array $commands = [
        UserCreateCommand::class
    ];

    /**
     * @var array|string[]
     */
    protected array $projectors = [
        RoleProjector::class,
        UserProjector::class,
        ExpenseProjector::class
    ];

    /**
     * @var array|string[]
     */
    protected array $reactors = [
        UserReactor::class
    ];
}
