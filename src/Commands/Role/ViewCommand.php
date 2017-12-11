<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class ViewCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class ViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:view {role : Role name}';

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
            return 1;
        }

        echo "Role: {$role->name} (ID = {$role->id})", PHP_EOL;
        echo "Created at: {$role->created_at}", PHP_EOL;
        echo "Updated at: {$role->updated_at}", PHP_EOL;
        echo "Permissions:", PHP_EOL;

        $data = collect($role->permissions->toArray())->map(function($item) {
            unset($item['pivot']);
            return $item;
        });

        if ($role->permissions->count()) {
            $this->table(['ID', 'Permission', 'Created At', 'Updated At'], $data);
        } else {
            $this->warn("Not found any permissions!");
        }

        return 0;
    }

}
