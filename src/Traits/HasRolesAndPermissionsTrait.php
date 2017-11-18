<?php

namespace Muan\Acl\Traits;

use Muan\Acl\Models\{
    Role,
    Permission
};

/**
 * Trait HasRolesAndPermissionsTrait
 * 
 * @package Muan\Acl
 * @subpackage Traits
 */
trait HasRolesAndPermissionsTrait
{

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

}