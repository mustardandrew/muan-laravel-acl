<?php

namespace Muan\Acl\Commands\Permission;

use Illuminate\Console\Command;
use Muan\Acl\Models\Permission;

/**
 * Class AddCommand
 *
 * @package Muan\Acl\Commands\Permission
 */
class AddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add {permissions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissionName = $this->argument('permission');

        if ($permission = Permission::whereName($permissionName)->first()) {
            $this->warn("Permission name {$permissionName} already exists.");
            return 1;
        }

        if ($permission = Permission::create(['name' => $permissionName])) {
            echo "Permission {$permissionName} created successfully.", PHP_EOL;
        } else {
            $this->error("Permission {$permissionName} not created!");
        }

        return 0;
    }

}