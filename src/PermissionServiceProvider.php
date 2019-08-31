<?php

namespace CodexShaper\Permission;

use CodexShaper\Permission\Commands\InstallPermission;
use CodexShaper\Permission\Http\Middleware\RoleMiddleware;
use CodexShaper\Permission\PermissionGenarator;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('permission', function(){
            return new PermissionGenarator(); 
        });

         $this->loadHelpers();

        $this->mergeConfigFrom(
            __DIR__.'/../config/permission.php', 'config'
        );

        $this->registerMiddleware();
        $this->registerPublish();
        $this->registerCommands();
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function registerMiddleware()
    {
        /** @var Kernel|\Illuminate\Foundation\Http\Kernel $kernel */
        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
    }

    protected function registerPublish()
    {
        $publishable = [
            'permission.config' => [
                __DIR__.'/../config/permission.php' => config_path('permission.php'),
            ],
            'permission.seeds' => [
                __DIR__."/../database/seeds/" => database_path('seeds'),
            ],
        ];
        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    private function registerCommands()
    {
        $this->commands(InstallPermission::class);
    }
}
