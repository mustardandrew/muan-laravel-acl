<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Muan\Acl\Traits\PrepareUserTrait;
use Exception;

/**
 * Class ViewCommand
 *
 * @package Muan\Acl\Commands\User
 */
class ViewCommand extends Command
{
    use PrepareUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:view {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show information about user.';

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

        echo "User name: {$user->name} (ID = {$user->id})", PHP_EOL;
        echo "Created at: {$user->created_at}", PHP_EOL;
        echo "Updated at: {$user->updated_at}", PHP_EOL;

        $this->showRoles($user);
        $this->showPermissions($user);

        return 0;
    }

    /**
     * Show information about roles
     *
     * @param $user
     */
    protected function showRoles($user)
    {
        if (! $user->roles) {
            $this->warn("User not use HasRolesTrait!");
            return;
        }

        echo "Roles:", PHP_EOL;

        $data = collect($user->roles->toArray())->map(function($item) {
            unset($item['pivot']);
            return $item;
        });

        if ($user->roles->count()) {
            $this->table(['ID', 'Role', 'Created At', 'Updated At'], $data);
        } else {
            $this->warn("Not found any roles!");
        }
    }

    /**
     * Show information about permission
     *
     * @param $user
     */
    protected function showPermissions($user)
    {
        if (! $user->permissions) {
            $this->warn("User not use HasPermissionsTrait!");
            return;
        }

        echo "Permissions:", PHP_EOL;

        $data = collect($user->permissions->toArray())->map(function($item) {
            unset($item['pivot']);
            return $item;
        });

        if ($user->permissions->count()) {
            $this->table(['ID', 'Permission', 'Created At', 'Updated At'], $data);
        } else {
            $this->warn("Not found any permissions!");
        }
    }
}
