<?php

namespace Muan\Acl;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Gate, Blade, Route};

use Muan\Acl\Middleware\{RoleMiddleware, PermissionMiddleware};
use Muan\Acl\Models\Permission;

/**
 * Class AclServiceProvider
 * 
 * @package Muan\Acl
 */
class AclServiceProvider extends ServiceProvider
{

    /**
     * Commands
     * 
     * @var array
     */
    protected $commands = [
        \Muan\Acl\Commands\Role\ListCommand::class,
        \Muan\Acl\Commands\Role\AddCommand::class,
    ];

    /**
     * Boot
     * 
     * @return void
     */
    public function boot()
    {
        $this->initMigrations();
        $this->initPermissions();
        $this->initMiddlewares();
        $this->initDirectives();
        $this->initCommands();
    }

    /**
     * Initialization migrations
     * 
     * @return void
     */
    protected function initMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . "/migrations");
    }

    /**
     * Initialization permissions
     * 
     * @return void
     */
    protected function initPermissions()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        Permission::get()->map(function(Permission $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });        
    }

    /**
     * Initialization middlewares
     * 
     * @return void
     */
    protected function initMiddlewares()
    {
        Route::middleware('role', RoleMiddleware::class);
        Route::middleware('permission', PermissionMiddleware::class);
    }

    /**
     * Initialization directives
     * 
     * @return void
     */
    protected function initDirectives()
    {
        Blade::directive('role', function($role) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });
        Blade::directive('elserole', function($role) {
            return "<?php elseif ($role): ?>";
        });
        Blade::directive('endrole', function() {
            return "<?php endif; ?>";
        });
    }

    /**
     * Initialization commands
     * 
     * @return void
     */
    protected function initCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

}