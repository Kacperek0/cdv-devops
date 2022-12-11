<?php
/**
 * User: gmatk
 * Date: 22.06.2022
 * Time: 12:24
 */

namespace App\Domain\User\Providers;

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
    protected $namespace = 'App\Domain\User\Http\Controllers';

    /**
     *
     */
    public function map(): void
    {
        $this->authRoutes();
        $this->userRoutes();
        $this->expenseRoutes();
    }

    /**
     *
     */
    public function authRoutes(): void
    {
        Route::prefix('auth')
            ->middleware(['api'])
            ->namespace($this->namespace . '\Auth')
            ->group($this->domainPath('Routes/auth.php'));
    }

    /**
     *
     */
    public function userRoutes(): void
    {
        Route::prefix('user')
            ->middleware(['api'])
            ->namespace($this->namespace . '\User')
            ->group($this->domainPath('Routes/user.php'));
    }

    /**
     *
     */
    public function expenseRoutes(): void
    {
        Route::prefix('expense')
            ->middleware(['api'])
            ->namespace($this->namespace . '\Expense')
            ->group($this->domainPath('Routes/expense.php'));
    }
}
