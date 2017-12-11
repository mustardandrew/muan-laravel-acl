<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class DetachPermissionCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class DetachPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:detach {role : Role name}
                            {--id=* : Permission ID}
                            {--name=* : Permission name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detach permission';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roleName = $this->argument('role');

        if (! $role = Role::whereName($roleName)->first()) {
            $this->warn("Role {$roleName} not exists.");
            return 1;
        }

        $attachList = array_merge($this->option('id'), $this->option('name'));

        $role->detachPermission($attachList);
        echo "Detached permissions. Done!", PHP_EOL;

        return 0;
    }

}
