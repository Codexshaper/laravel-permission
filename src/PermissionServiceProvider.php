<?php

namespace CodexShaper\Permission;

use CodexShaper\Permission\Commands\InstallPermission;
use CodexShaper\Permission\Http\Middleware\RoleMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'permission');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('permission', function(){
            return new Permission(); 
        });

         $this->loadHelpers();

        $this->mergeConfigFrom(
            __DIR__.'/../config/permission.php', 'config'
        );

        $this->registerMiddleware();
        $this->registerPublish();
        $this->registerBladeDirectives();
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
            'permission.views' => [
                __DIR__.'/../resources/views' => resource_path('views/vendor/permissions'),
            ],
        ];
        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    protected function registerBladeDirectives() {
        $this->app->afterResolving('blade.compiler', function( BladeCompiler $blade ){
            $blade->directive('can', function ($permission) {
                    return "<?php if(auth()->user() && auth()->user()->hasPermission({$permission})): ?>";
                });
            $blade->directive('endcan', function ($expression) {
                    return "<?php endif; ?>";
                });

            $blade->directive('role', function ($role) {
                return "<?php if(auth()->user() && auth()->user()->hasRole({$role})): ?>";
            });
            $blade->directive('endrole', function () {
                return '<?php endif; ?>';
            });

            $blade->directive('hasrole', function ($arguments) {
                list($role, $guard) = explode(',', $arguments.',');
                dd( auth($guard) );
                return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasRole({$role})): ?>";
            });
            $blade->directive('endhasrole', function () {
                return '<?php endif; ?>';
            });
        });
        
    }

    private function registerCommands()
    {
        $this->commands(InstallPermission::class);
    }
}
