<?php

namespace Muan\Acl\Traits;

use Muan\Acl\Models\Permission;

/**
 * Trait HasPermissionsTrait
 * 
 * @package Muan\Acl\Traits
 */
trait HasPermissionsTrait
{

    /**
     * Has permission
     * 
     * @param mixed $permission
     * @return boolean
     */
    public function hasPermission($permission)
    {
        $name = $permission instanceof Permission ? $permission->name : $permission;

        return $this->hasPermissionThroughRole($permission) 
            || ((bool) $this->permissions->whereName($name)->count());
    }

    /**
     * Has permission through role
     * 
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermissionThroughRole($permission)
    {
        if (! method_exists($this, 'roles')) {
            return false;
        }

        if (is_string($permission)) {
            if (! $permission = Permission::whereName($permission)->first()) {
                return false;
            }
        }

        foreach ($permission->roles as $role) { 
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add permission
     * 
     * @param mixed ...$permissions
     * @return $this
     */
    public function addPermission(...$permissions)
    {
        $permissions = array_flatten($permissions);

        foreach ($permissions as $permission) {
            if ($this->hasPermission($role)) {
                continue;
            }

            if ($permission instanceof Permission) {
                $this->attach($permission->id);
            } elseif ($permission = Permission::whereName($permission)->first()) {
                $this->attach($permission->id);
            }
        }

        return $this;
    }

    /**
     * Remove permission
     * 
     * @param mixed ...$permissions
     * @return $this
     */
    public function removePermission(...$permissions)
    {
        $permissions = array_flatten($permissions);

        foreach ($permissions as $permission) {
            if (! $this->hasPermission($permission)) {
                continue;
            }

            if ($permission instanceof Permission) {
                $this->detach($permission->id);
            } elseif ($permission = Permission::whereName($permission)->first()) {
                $this->detach($permission->id);
            }   
        }

        return $this;
    }

    /**
     * Crear all permissions
     *
     * @return $this
     */
    public function clearPermissions() 
    {
        $this->permissions()->detach();

        return $this;
    }

    /**
     * Relation to permissions
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

}