<?php

namespace Muan\Acl\Commands\Permission;

use Illuminate\Console\Command;
use Muan\Acl\Models\Permission;

/**
 * Class ListCommand
 *
 * @package Muan\Acl\Commands\Permission
 */
class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show permission list';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = Permission::all(['id', 'name', 'created_at', 'updated_at']);

        if ($permissions->count()) {
            $this->table(
                ['ID', 'Permission', 'Created At', 'Updated At'],
                $permissions->toArray()
            );
        } else {
            $this->warn("Not found any permissions!");
        }

        return 0;
    }

}
