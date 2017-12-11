<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class DetachRoleCommand
 *
 * @package Muan\Acl\Commands\User
 */
class DetachRoleCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role-detach {id : User ID}
                            {--id=* : Role id}
                            {--name=* : Role name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detach role';

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

        if (! method_exists($user, 'detachRole')) {
            $this->warn("User not use HasRolesTrait!");
            return 1;
        }

        $user->detachRole($detachList);
        echo "Detached roles. Done!", PHP_EOL;

        return 0;
    }

}
