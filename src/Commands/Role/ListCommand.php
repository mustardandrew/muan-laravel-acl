<?php

namespace Muan\Acl\Commands\Role;

use Illuminate\Console\Command;
use Muan\Acl\Models\Role;

/**
 * Class ListCommand
 *
 * @package Muan\Acl\Commands\Role
 */
class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show role list';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = Role::all(['id', 'name', 'created_at', 'updated_at']);

        if ($roles->count()) {
            $this->table(['ID', 'Role', 'Created At', 'Updated At'], $roles->toArray());
        } else {
            $this->warn("Not found any roles!");
        }
    }

}
