<?php

namespace Muan\Acl\Commands\Permission;

use Illuminate\Console\Command;
use Muan\Acl\Models\Permission;

/**
 * Class RemoveCommand
 *
 * @package Muan\Acl\Commands\Permission
 */
class RemoveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:remove {permission : Permission name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove permission';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissionName = $this->argument('permission');

        if (! $permission = Permission::whereName($permissionName)->first()) {
            $this->warn("Permission {$permissionName} not exists.");
            return 1;
        }

        if ($permission->delete()) {
            echo "Permission {$permissionName} removed successfully.", PHP_EOL;
        } else {
            $this->error("Permission {$permissionName} not removed!");
        }

        return 0;
    }

}
