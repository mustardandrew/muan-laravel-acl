<?php

namespace Muan\Acl;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

use Muan\Acl\Middleware\RoleMiddleware;
use Muan\Acl\Commands\Role\ListCommand;
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
     * @var array
     */
    protected $commands = [
        ListCommand::class,
    ];

    /**
     * Boot
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/migrations");

        if (! $this->app->runningInConsole()) {
            Permission::get()->map(function(Permission $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        }

        Route::middleware('role', RoleMiddleware::class);

        // has role directive
        Blade::directive('role', function($role) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });
        Blade::directive('endrole', function() {
            return "<?php endif; ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register
     * @return void
     */
    public function register()
    {
        //
    }

}