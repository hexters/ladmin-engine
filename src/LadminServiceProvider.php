<?php

namespace Ladmin\Engine;;

use Ladmin\Engine\Console\Commands\GenerateDataTablesCommand;
use Ladmin\Engine\Console\Commands\GenerateMenuCommand;
use Ladmin\Engine\Console\Commands\GenerateSearchGroupCommand;
use Ladmin\Engine\Console\Commands\InstallPackageCommand;
use Ladmin\Engine\Console\Commands\InstallPackageModuleCommand;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class LadminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        if (!file_exists(config_path('ladmin.php'))) {
            $this->mergeConfigFrom(
                __DIR__ . '/config/ladmin.php',
                'ladmin'
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * Publish menu kernel
         */
        $this->publishes([
            __DIR__ . '/../Menu' => app_path('Menu'),
        ], 'ladmin-menu');

        /**
         * Publish custom route stub
         */
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs'),
        ], 'ladmin-stub');


        /**
         * Publish config file with admin option
         */
        $this->publishes([
            __DIR__ . '/config/ladmin.php' => config_path('ladmin.php'),
            __DIR__ . '/config/scout.php' => config_path('scout.php'),
            __DIR__ . '/config/auth.php' => config_path('auth.php'),
        ], 'ladmin-config');

        /**
         * Publish config file with admin option
         */
        $this->publishes([
            __DIR__ . '/Seeders/stubs' => base_path('database/seeders'),
        ], 'ladmin-database-seeder');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateMenuCommand::class,
                GenerateDataTablesCommand::class,
                InstallPackageCommand::class,
                InstallPackageModuleCommand::class,
                GenerateSearchGroupCommand::class,
            ]);
        }

        /** 
         * Register migration path
         */
        $this->loadMigrationsFrom(__DIR__ . '/databases');

        /**
         * Register gates access
         */
        foreach (ladmin()->menu()->allGates() as $gate) {
            Gate::define($gate, function (User $user) use ($gate) {
                $gates = [];
                foreach ($user->roles as $role) {
                    if (!is_null($role->gates)) {
                        array_push($gates, ...$role->gates);
                    } else {
                        array_push($gates);
                    }
                }
                return in_array($gate, $gates);
            });
        }
    }
}
