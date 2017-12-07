<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class AddCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class AddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add role';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roleName = $this->argument('role');

        if ($role = Role::whereName($roleName)->first()) {
            $this->warn("Role name {$roleName} already exists.");
            return 1;
        }

        if ($role = Role::create(['name' => $roleName])) {
            echo "Role {$roleName} created successfully.", PHP_EOL;
        } else {
            $this->error("Role {$roleName} not created!");
        }

        return 0;
    }

}
