<?php

namespace Muan\Acl\Traits;

use Muan\Acl\Models\Permission;

/**
 * Trait HasPermissions
 * 
 * @package Muan\Acl
 * @subpackage Traits
 */
trait HasPermissions
{

    /**
     * Give permission to
     * @param $permissions
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));

        if ($permission === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Withdraw permission to
     * @param $permissions
     * @return $this
     */
    public function withdrawPermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * Refresh permission to
     * @param $permissions
     * @return $this
     */
    public function refreshPermissionTo(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);        
    }

    /**
     * Has permission to
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermissionTo(Permission $permission)
    {
        return  $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Has permission through role
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermissionThroughRole(Permission $permission)
    {
        if (! method_exists($this, 'roles')) {
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
     * Has permission
     * @param Permission $permission
     * @return boolean
     */
    protected function hasPermission(Permission $permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    /**
     * Get all permissions
     * @param array $permissions
     * @return
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * Permissions
     * @return [type] [description]
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

}