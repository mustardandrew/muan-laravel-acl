<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class DetachPermissionCommand
 *
 * @package Muan\Acl\Commands\User
 */
class DetachPermissionCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:permission-detach {id}
                            {--id=* : Permission id}
                            {--name=* : Permission name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detach permission';

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

        $detachList = array_merge($this->option('id'), $this->option('name'));

        if (! method_exists($user, 'detachPermission')) {
            $this->warn("User not use HasPermissionsTrait!");
            return 1;
        }

        $user->detachPermission($detachList);
        echo "Detached permissions. Done!", PHP_EOL;

        return 0;
    }

}
