<?php

namespace Muan\Acl\Traits;

use Muan\Acl\Models\Role;

/**
 * Trait HasRoles
 * 
 * @package Muan\Acl\Traits
 */
trait HasRolesTrait
{

    /**
     * Has role
     * 
     * @param mixed $roles
     * @return boolean
     */
    public function hasRole(...$roles)
    {
        $roles = array_flatten($roles);

        foreach ($roles as $role) {
            $name = $role instanceof Role ? $role->name : $role;

            if ($this->roles->contains('name', $name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add role
     * 
     * @param mixed ...$roles
     * @return $this
     */
    public function addRole(...$roles) 
    {
        $roles = array_flatten($roles);

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                continue;
            }

            if ($role instanceof Role) {
                $this->attach($role->id);
            } elseif ($role = Role::whereName($role)->first()) {
                $this->attach($role->id);
            }
        }

        return $this;
    }

    /**
     * Remove role
     * 
     * @param mixed ...$roles
     * @return $this
     */
    public function removeRole(...$roles)
    {
        $roles = array_flatten($roles);

        foreach ($roles as $role) {
            if (! $this->hasRole($role)) {
                continue;
            }

            if ($role instanceof Role) {
                $this->detach($role->id);
            } elseif ($role = Role::whereName($role)->first()) {
                $this->detach($role->id);
            }   
        }

        return $this;
    }

    /**
     * Crear all roles
     *
     * @return $this
     */
    public function clearRoles() 
    {
        $this->roles()->detach();

        return $this;
    }

    /**
     * Relation to roles
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

}