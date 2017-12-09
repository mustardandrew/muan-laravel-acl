<?php

namespace Muan\Acl\Models;

/**
 * Class UserModel
 * 
 * @package Muan\Acl\Models
 */
class UserObserver
{

    /**
     * Listen to the User created event.
     *
     * @param object $user
     * @return void
     */
    public function created($user)
    {
        if (! $baseName = $user->baseRole) {
            return;
        }
 
        // Attach base role
        if (method_exists($user, 'attachRole')) {
            $user->attachRole($baseName);
        }
    }

}