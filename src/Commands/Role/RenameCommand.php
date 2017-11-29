<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class RenameCommand
 *
 * @package Muan\Acl
 * @subpackage Commands
 */
class RenameCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:rename {role} {newRole}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename role';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roleName = $this->argument('role');
        $newRoleName = $this->argument('newRole');

        if (! $role = Role::whereName($roleName)->first()) {
            $this->warn("Role {$roleName} not exists.");
            return;
        }

        $role->name = $newRoleName;

        if ($role->save()) {
            echo "Rename role {$roleName} to {$newRoleName} successfully.", PHP_EOL;
        } else {
            $this->error("Rename role {$roleName} is fail!");
        }
    }

}
