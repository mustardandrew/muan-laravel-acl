<?php

namespace Muan\Acl\Traits;

use Exception;

/**
 * Trait PrepareUserTrait
 *
 * @package Muan\Acl\Traits
 */
trait PrepareUserTrait
{

    /**
     * Prepare user
     *
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function prepareUser(integer $id)
    {
        $userClass = config('auth.providers.users.model');

        if (! class_exists($userClass)) {
            throw new Exception("User class {$userClass} not found.");
        }

        if(! $user = $userClass::whereId($id)->first()) {
            throw new Exception("User by ID {$id} not found.");
        }

        return $user;
    }

}