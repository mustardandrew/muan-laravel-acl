<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class AttachPermissionCommand
 *
 * @package Muan\Acl\Commands\User
 */
class AttachPermissionCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:permission-attach {id : User ID}
                            {--id=* : Permission id}
                            {--name=* : Permission name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach permission';

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

        $attachList = array_merge($this->option('id'), $this->option('name'));

        if (! method_exists($user, 'attachPermission')) {
            $this->warn("User not use HasPermissionsTrait!");
            return 1;
        }

        $user->attachPermission($attachList);
        echo "Attached permissions. Done!", PHP_EOL;

        return 0;
    }

}
