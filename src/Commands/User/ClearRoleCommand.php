<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class ClearRoleCommand
 *
 * @package Muan\Acl\Commands\User
 */
class ClearRoleCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role-clear {id : User ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear roles';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');

        try {
            $user = $this->prepareUser($id);
        } catch (Exception $e) {
            $this->warn($e->getMessage());
            return 1;
        }

        if (! method_exists($user, 'clearRoles')) {
            $this->warn("Method clearRoles not found!");
        }

        $user->clearRoles();
        echo "Clear roles. Done!", PHP_EOL;

        return 0;
    }

}
