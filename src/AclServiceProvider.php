<?php

namespace Muan\Acl;

use Illuminate\Support\ServiceProvider;

/**
 * Class AclServiceProvider
 * @package Muan\Acl
 */
class AclServiceProvider extends ServiceProvider
{

    /**
     * Boot
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/migrations");
    }

    /**
     * Register
     * @return void
     */
    public function register()
    {
        //
    }

}