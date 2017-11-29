<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class ListCommand
 *
 * @package Muan\Acl
 * @subpackage Commands
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
            echo PHP_EOL;
            $this->error("Role name {$roleName} already exists.");
            echo PHP_EOL;
            return;
        }

        if ($role = Role::create(['name' => $roleName])) {
            echo PHP_EOL, "Role {$roleName} created successfully.", str_repeat(PHP_EOL, 2);
        } else {
            echo PHP_EOL;
            $this->error("Role {$roleName} not created!");
            echo PHP_EOL;
        }

    }

}
