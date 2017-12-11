<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class ClearPermissionCommand
 *
 * @package Muan\Acl\Commands\User
 */
class ClearPermissionCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:permission-clear {id : User ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear permissions';

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

        if (! method_exists($user, 'clearPermissions')) {
            $this->warn("Method clearPermissions not found!");
        }

        $user->clearPermissions();
        echo "Clear permissions. Done!", PHP_EOL;

        return 0;
    }

}
