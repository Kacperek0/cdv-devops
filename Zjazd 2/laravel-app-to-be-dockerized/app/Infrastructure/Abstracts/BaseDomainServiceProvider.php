<?php

namespace App\Infrastructure\Abstracts;

use App\Infrastructure\Contracts\ScheduleContract;
use App\Infrastructure\Traits\DomainResolverTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

/**
 * Class PokatoDomainServiceProvider
 * @package Pokato\Support\Providers
 */
abstract class BaseDomainServiceProvider extends LaravelServiceProvider
{
    use DomainResolverTrait;

    /**
     * @var string Alias for load tranlations and views
     */
    protected string $alias;

    /**
     * @var bool
     */
    protected bool $hasMigrations = false;

    /**
     * @var bool
     */
    protected bool $hasTranslations = false;

    /**
     * @var bool
     */
    protected bool $hasViews = false;

    /**
     * @var bool
     */
    protected bool $hasConfigs = false;

    /**
     * @var array List of custom Artisan commands
     */
    protected array $commands = [];

    /**
     * @var array List of providers to load
     */
    protected array $providers = [];

    /**
     * @var array List of policies to load
     */
    protected array $policies = [];

    /**
     * @var array
     */
    protected array $configs = [];

    /**
     * @var array
     */
    protected array $domainBindings = [];

    /**
     * @var array
     */
    protected array $scheduledCommands = [];
    /**
     * @var array
     */
    protected array $projectors = [];
    /**
     * @var array
     */
    protected array $reactors = [];

    /**
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerBindings();
        $this->registerScheduledCommands();
        $this->registerProjectors();
        $this->registerReactors();
    }

    /**
     * Register Domain ServiceProviders & Configs.
     */
    public function register(): void
    {
        $this->registerConfigs();
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }

    /**
     *
     */
    public function registerBindings(): void
    {
        foreach ($this->domainBindings as $contract => $implementation) {
            $this->app->bind($contract, $implementation);
        }

    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies(): void
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register domain custom Artisan commands.
     */
    protected function registerCommands(): void
    {
        $this->commands($this->commands);

    }

    /**
     *
     */
    protected function registerMigrations(): void
    {
        if ($this->hasMigrations) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }

    /**
     *
     */
    protected function registerTranslations(): void
    {
        if ($this->hasTranslations) {
            $this->loadJsonTranslationsFrom($this->domainPath('Resources/Lang'));
        }
    }

    /**
     *
     */
    protected function registerViews(): void
    {
        if ($this->hasViews) {
            view()->addNamespace($this->alias, $this->domainPath('Resources/Views'));
        }
    }

    /**
     */
    protected function registerConfigs(): void
    {
        foreach ($this->configs as $config) {
            $this->mergeConfigFrom($this->domainPath('Configs') . '/' . sprintf('%s.php', $config), $config);
        }

    }

    /**
     *
     */
    protected function registerScheduledCommands(): void
    {
        $this->app->booted(function () {
            foreach ($this->scheduledCommands as $command) {
                /**
                 * @var ScheduleContract $handler
                 */
                $handler = new $command();
                $handler->handle($this->app->make(Schedule::class));
            }
        });
    }

    /**
     *
     */
    protected function registerProjectors(): void
    {
        Projectionist::addProjectors($this->projectors);
    }

    /**
     *
     */
    protected function registerReactors(): void
    {
        Projectionist::addReactors($this->reactors);
    }
}
