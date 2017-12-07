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
     * Attach role
     * 
     * @param mixed ...$roles
     * @return $this
     */
    public function attachRole(...$roles)
    {
        $this->each($roles, function($role) {
            if (! $this->hasRole($role)) {
                $this->roles()->attach($role->id);
            }
        });

        return $this;
    }

    /**
     * Detach role
     * 
     * @param mixed ...$roles
     * @return $this
     */
    public function detachRole(...$roles)
    {
        $this->each($roles, function($role) {
            if ($this->hasRole($role)) {
                $this->roles()->detach($role->id);
            }
        });

        return $this;
    }

    /**
     * Clear all roles
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Prepare role
     * 
     * @param Role|int|string $role
     * @return Role
     */
    protected function prepareRole($role)
    {
        if ($role instanceof Role) {
            return $role;
        }

        if (is_numeric($role)) {
            return Role::whereId($role)->first();
        }

        return Role::whereName($role)->first();
    }

    /**
     * Calc each rote
     * 
     * @param array $roles
     * @param callable $callback
     */
    protected function each(array $roles, callable $callback)
    {
        $roles = array_flatten($roles);

        foreach ($roles as $role) {
            if ($role = $this->prepareRole($role)) {
                $callback($role);    
            }
        }
    } 

}