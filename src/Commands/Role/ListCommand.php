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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = Role::all(['id', 'name']);
        if ($roles->count()) {
            $this->table(['ID', 'Role'], $roles->toArray());
        } else {
            echo "Not found any roles!", PHP_EOL;
        }
    }

}
