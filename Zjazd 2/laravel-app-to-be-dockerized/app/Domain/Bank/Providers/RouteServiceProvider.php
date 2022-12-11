<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 12:24
 */

namespace App\Domain\Bank\Providers;

use App\Infrastructure\Traits\DomainResolverTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;


/**
 *
 */
class RouteServiceProvider extends ServiceProvider
{
    use DomainResolverTrait;

    /**
     * @var string
     */
    protected $namespace = 'App\Domain\Bank\Http\Controllers';

    /**
     *
     */
    public function map(): void
    {
        $this->bankRoutes();
    }

    /**
     *
     */
    public function bankRoutes(): void
    {
        Route::prefix('bank')
            ->middleware(['api','auth:api'])
            ->namespace($this->namespace)
            ->group($this->domainPath('Routes/bank.php'));
    }
}
