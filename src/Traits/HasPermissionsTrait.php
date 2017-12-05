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
        return (bool) $this->permissions->whereName($name)->count();
    }

    /**
     * Add permission
     * 
     * @param mixed ...$permissions
     * @return $this
     */
    public function addPermission(...$permissions)
    {
        $this->each($permissions, function($permission) {
            if (! $this->hasDirectPermission($permission)) {
                $this->attach($permission->id);
            }
        });

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
        $this->each($permissions, function($permission) {
            if ($this->hasDirectPermission($permission)) {
                $this->detach($permission->id);
            }
        });

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

    /**
     * Prepare permission
     * @param Permission|string $permission
     * @return Permission
     */
    protected function preparePermission($permission)
    {
        if ($permission instanceof Permission) {
            return $permission;
        }

        return Permission::whereName($permission)->first();
    }

    /**
     * Calc each permission
     * 
     * @param array $permissions
     * @param callable $callback
     */
    protected function each(array $permissions, callable $callback)
    {
        $permissions = array_flatten($permissions);

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