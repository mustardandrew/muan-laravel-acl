<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class RoleCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class RoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show information about role.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roleName = $this->argument('role');

        if (! $role = Role::whereName($roleName)->first()) {
            $this->warn("Role {$roleName} not found!");
            return;
        }

        echo "Role: {$role->name} ({$role->id})", PHP_EOL;
        echo "Permissions:", PHP_EOL;

        // TODO: Show permissions

    }

}
