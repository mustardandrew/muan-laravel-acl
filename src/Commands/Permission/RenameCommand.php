<?php

namespace Muan\Acl\Commands\Permission;

use Illuminate\Console\Command;
use Muan\Acl\Models\Permission;

/**
 * Class RenameCommand
 *
 * @package Muan\Acl\Commands\Permission
 */
class RenameCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:rename {permission} {newPermission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename permission';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissionName = $this->argument('permission');
        $newPermissionName = $this->argument('newPermission');

        if (! $permission = Permission::whereName($permissionName)->first()) {
            $this->warn("Permission {$permissionName} not exists.");
            return 1;
        }

        $permission->name = $newPermissionName;

        if ($permission->save()) {
            echo "Rename permission {$permissionName} to {$newPermissionName} successfully.", PHP_EOL;
        } else {
            $this->error("Rename permission {$permissionName} is fail!");
        }

        return 0;
    }

}
