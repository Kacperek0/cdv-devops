<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 11:59
 */

namespace App\Domain\Bank\Providers;

use App\Application\Repositories\BankRepository;
use App\Domain\Bank\Console\Commands\ImportCategoryCouplingsCommand;
use App\Domain\Bank\Projectors\BankProjector;
use App\Domain\Bank\Repositories\BankRepositoryEloquent;
use App\Infrastructure\Abstracts\BaseDomainServiceProvider;

/**
 *
 */
class DomainServiceProvider extends BaseDomainServiceProvider
{
    /**
     * @var string
     */
    protected string $alias = 'bank';
    /**
     * @var bool
     */
    protected bool $hasMigrations = true;

    /**
     * @var array|string[]
     */
    protected array $domainBindings = [
        BankRepository::class => BankRepositoryEloquent::class
    ];

    /**
     * @var array|string[]
     */
    protected array $providers = [
        RouteServiceProvider::class
    ];

    /**
     * @var array|string[]
     */
    protected array $projectors = [
        BankProjector::class
    ];

    /**
     * @var array|string[]
     */
    protected array $commands = [
        ImportCategoryCouplingsCommand::class
    ];

}
