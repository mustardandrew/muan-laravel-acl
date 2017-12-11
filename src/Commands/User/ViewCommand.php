<?php

namespace Muan\Acl\Commands\User;

use Illuminate\Console\Command;
use Illuminate\Contracts\Support\Arrayable;
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
    protected $signature = 'user:view {id : User ID}';

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

        $this->show($user, 'role');
        $this->show($user, 'permission');

        return 0;
    }

    /**
     * Show roles or permissions
     *
     * @param $user
     * @param string $modelName
     */
    protected function show($user, string $modelName)
    {
        $method = "{$modelName}s";
        $methodTitle = ucfirst($method);

        if (! $user->$method) {
            $this->warn("User not use Has{$methodTitle}Trait!");
            return;
        }

        echo "{$methodTitle}:", PHP_EOL;

        $data = $this->prepareData($user->$method->toArray());

        if ($user->$method->count()) {
            $this->table(['ID', ucfirst($modelName), 'Created At', 'Updated At'], $data);
        } else {
            $this->warn("Not found any {$method}!");
        }
    }

    /**
     * Prepare data
     *
     * @param array $data
     * @return Arrayable
     */
    protected function prepareData(array $data) : Arrayable
    {
        return  collect($data)->map(function($item) {
            unset($item['pivot']);
            return $item;
        });
    }

}
