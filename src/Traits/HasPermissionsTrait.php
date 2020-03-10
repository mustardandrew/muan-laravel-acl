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
        return $this->hasPermissionThroughRole($permission) || $this->hasDirectPermission($permission);
    }

    /**
     * Has permission through role
     * 
     * @param Permission|string $permission
     * @return boolean
     */
    public function hasPermissionThroughRole($permission)
    {
        if (! $this->isMethodRolesExists()) {
            return false;
        }

        if (! $permission = $this->preparePermission($permission)) {
            return false;   
        }

        foreach ($permission->roles as $role) { 
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Has direct permission
     *
     * @param Permission|string $permission
     * @return boolean
     */
    public function hasDirectPermission($permission)
    {
        $name = $permission instanceof Permission ? $permission->name : $permission;
        return (bool) $this->permissions->where('name', $name)->count();
    }

    /**
     * Attach permission
     * 
     * @param mixed ...$permissions
     * @return $this
     */
    public function attachPermission(...$permissions)
    {
        $this->eachPermission($permissions, function($permission) {
            if (! $this->hasDirectPermission($permission)) {
                $this->permissions()->attach($permission->id);
            }
        });

        return $this;
    }

    /**
     * Detach permission
     * 
     * @param mixed ...$permissions
     * @return $this
     */
    public function detachPermission(...$permissions)
    {
        $this->eachPermission($permissions, function($permission) {
            if ($this->hasDirectPermission($permission)) {
                $this->permissions()->detach($permission->id);
            }
        });

        return $this;
    }

    /**
     * Clear all permissions
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * Prepare permission
     * 
     * @param Permission|string $permission
     * @return Permission
     */
    public function preparePermission($permission)
    {
        if ($permission instanceof Permission) {
            return $permission;
        }

        if (is_numeric($permission)) {
            return Permission::whereId($permission)->first();
        }

        return Permission::whereName($permission)->first();
    }

    /**
     * Calc each permission
     * 
     * @param array $permissions
     * @param callable $callback
     */
    public function eachPermission(array $permissions, callable $callback)
    {
        $permissions = (function_exists('array_flatten'))
            ? array_flatten($permissions)
            : \Arr::flatten($permissions);

        foreach ($permissions as $permission) {
            if ($permission = $this->preparePermission($permission)) {
                $callback($permission);    
            }
        }
    }

    /**
     * Is method roles exists
     * 
     * @return bool
     */
    protected function isMethodRolesExists()
    {
        return method_exists($this, 'roles');
    }

}
