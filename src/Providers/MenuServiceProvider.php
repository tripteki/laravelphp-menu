<?php

namespace Tripteki\Menu\Providers;

use Tripteki\Menu\Models\Menu;
use Tripteki\Uid\Observers\UniqueIdObserver;
use Tripteki\Menu\Console\Commands\InstallCommand;
use Tripteki\Repository\Providers\RepositoryServiceProvider as ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories =
    [
        \Tripteki\Menu\Contracts\Repository\IMenuRepository::class => \Tripteki\Menu\Repositories\Eloquent\MenuRepository::class,
        \Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository::class => \Tripteki\Menu\Repositories\Eloquent\Admin\MenuAdminRepository::class,
    ];

    /**
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * @return bool
     */
    public static function shouldRunMigrations()
    {
        return static::$runsMigrations;
    }

    /**
     * @return void
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * @param string $file
     * @return string
     */
    public static function locate($file)
    {
        return asset($file);
    }

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->dataEventListener();

        $this->registerPublishers();
        $this->registerCommands();
        $this->registerMigrations();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if (! $this->app->isProduction() && $this->app->runningInConsole()) {

            $this->commands(
            [
                InstallCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole() && static::shouldRunMigrations()) {

            $this->loadMigrationsFrom(__DIR__."/../../database/migrations");
        }
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        if (! static::shouldRunMigrations()) {

            $this->publishes(
            [
                __DIR__."/../../database/migrations" => database_path("migrations"),
            ],

            "tripteki-laravelphp-menu-migrations");
        }
    }

    /**
     * @return void
     */
    public function dataEventListener()
    {
        Menu::observe(UniqueIdObserver::class);
    }
};
