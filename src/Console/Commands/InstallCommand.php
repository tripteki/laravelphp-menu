<?php

namespace Tripteki\Menu\Console\Commands;

use Tripteki\Helpers\Helpers\ProjectHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "adminer:install:menu";

    /**
     * @var string
     */
    protected $description = "Install the menu stack";

    /**
     * @var \Tripteki\Helpers\Helpers\ProjectHelper
     */
    protected $helper;

    /**
     * @param \Tripteki\Helpers\Helpers\ProjectHelper $helper
     * @return void
     */
    public function __construct(ProjectHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $this->installStack();

        return 0;
    }

    /**
     * @return int|null
     */
    protected function installStack()
    {
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/user/menu.php", base_path("routes/user/menu.php"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/admin/menu.php", base_path("routes/admin/menu.php"));
        $this->helper->putRoute("api.php", "user/menu.php");
        $this->helper->putRoute("api.php", "admin/menu.php");

        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Menu"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Menu", app_path("Http/Controllers/Menu"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Menus", app_path("Http/Requests/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Admin/Menu"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Admin/Menu", app_path("Http/Controllers/Admin/Menu"));
        (new Filesystem)->ensureDirectoryExists(app_path("Imports/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Imports/Menus", app_path("Imports/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Exports/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Exports/Menus", app_path("Exports/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Admin/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Admin/Menus", app_path("Http/Requests/Admin/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Responses"));

        $this->info("Adminer Menu scaffolding installed successfully.");
    }
};
