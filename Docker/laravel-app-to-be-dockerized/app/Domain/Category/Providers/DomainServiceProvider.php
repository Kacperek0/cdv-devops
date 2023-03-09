<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 11:59
 */

namespace App\Domain\Category\Providers;

use App\Application\Repositories\CategoryCouplingRepository;
use App\Application\Repositories\CategoryRepository;
use App\Domain\Category\Projectors\CategoryProjector;
use App\Domain\Category\Projectors\CategoryCouplingProjector;
use App\Domain\Category\Repositories\CategoryCouplingRepositoryEloquent;
use App\Domain\Category\Repositories\CategoryRepositoryEloquent;
use App\Infrastructure\Abstracts\BaseDomainServiceProvider;

/**
 *
 */
class DomainServiceProvider extends BaseDomainServiceProvider
{
    /**
     * @var string
     */
    protected string $alias = 'category';
    /**
     * @var bool
     */
    protected bool $hasMigrations = true;

    /**
     * @var array|string[]
     */
    protected array $domainBindings = [
        CategoryRepository::class => CategoryRepositoryEloquent::class,
        CategoryCouplingRepository::class => CategoryCouplingRepositoryEloquent::class
    ];

    protected array $projectors = [
        CategoryProjector::class,
        CategoryCouplingProjector::class
    ];

}
