<?php

namespace Muan\Acl;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Gate, Blade, Route};

use Muan\Acl\Middleware\{RoleMiddleware, PermissionMiddleware};
use Muan\Acl\Models\{Permission, UserObserver};

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
        // Role
        \Muan\Acl\Commands\Role\ViewCommand::class,
        \Muan\Acl\Commands\Role\ListCommand::class,
        \Muan\Acl\Commands\Role\AddCommand::class,
        \Muan\Acl\Commands\Role\RemoveCommand::class,
        \Muan\Acl\Commands\Role\RenameCommand::class,
        \Muan\Acl\Commands\Role\AttachPermissionCommand::class,
        \Muan\Acl\Commands\Role\DetachPermissionCommand::class,
        \Muan\Acl\Commands\Role\ClearPermissionCommand::class,
        // Permission
        \Muan\Acl\Commands\Permission\ListCommand::class,
        \Muan\Acl\Commands\Permission\AddCommand::class,
        \Muan\Acl\Commands\Permission\RemoveCommand::class,
        \Muan\Acl\Commands\Permission\RenameCommand::class,
        // User
        \Muan\Acl\Commands\User\ClearRoleCommand::class,
        \Muan\Acl\Commands\User\ClearPermissionCommand::class,
        \Muan\Acl\Commands\User\ViewCommand::class,
        \Muan\Acl\Commands\User\AttachPermissionCommand::class,
        \Muan\Acl\Commands\User\DetachPermissionCommand::class,
        \Muan\Acl\Commands\User\AttachRoleCommand::class,
        \Muan\Acl\Commands\User\DetachRoleCommand::class,
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
        $this->initUserObserver();
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
                return $user->hasPermission($permission);
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
        Route::aliasMiddleware('role', RoleMiddleware::class);
        Route::aliasMiddleware('permission', PermissionMiddleware::class);
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
     * Initialization user observer
     * 
     * @return void
     */
    protected function initUserObserver()
    {
        $userClass = config('auth.providers.users.model');
        if (class_exists($userClass)) {
            $userClass::observe(UserObserver::class);
        }
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