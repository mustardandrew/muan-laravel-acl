<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class RemoveCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class RemoveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:remove {role : Role name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove role';

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

        if ($role->delete()) {
            echo "Role {$roleName} removed successfully.", PHP_EOL;
        } else {
            $this->error("Role {$roleName} not removed!");
        }

        return 0;
    }

}
