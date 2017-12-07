<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class ClearPermissionCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class ClearPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:clear {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear permission';

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

        $role->clearPermissions();
        echo "Clear permissions. Done!", PHP_EOL;

        return 0;
    }

}
