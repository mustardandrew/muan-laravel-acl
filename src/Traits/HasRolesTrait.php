<?php

namespace Muan\Acl\Traits;

use Muan\Acl\Models\Role;

/**
 * Trait HasRoles
 * 
 * @package Muan\Acl
 * @subpackage Traits
 */
trait HasRolesTrait
{

    /**
     * Has role
     * 
     * @param string $roles
     * @return boolean
     */
    public function hasRole(...$roles)
    {
        $roles = array_flatten($roles);

        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Relation to roles
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

}