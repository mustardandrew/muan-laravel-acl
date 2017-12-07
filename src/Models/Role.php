<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

use Muan\Acl\Traits\HasPermissionsTrait;

/**
 * Class Role
 * 
 * @package Muan\Acl\Models
 */
class Role extends Model
{
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Relation to permissions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    /**
     * Relations to user
     * 
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function users()
    {
        $userClass = config('app.providers.users.model');

        if (! class_exists($userClass)) {
            throw new Exception("User class {$userClass} not found!", 1);
        }

        return $this->belongsToMany($userClass, 'users_roles');
    }

}
