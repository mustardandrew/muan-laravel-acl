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
            echo PHP_EOL;
            $this->table(['ID', 'Role', 'Created At', 'Updated At'], $roles->toArray());
            echo PHP_EOL;
        } else {
            echo PHP_EOL, "Not found any roles!", str_repeat(PHP_EOL, 2);
        }
    }

}
