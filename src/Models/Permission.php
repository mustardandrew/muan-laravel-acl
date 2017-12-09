<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class Permission
 * 
 * @package Muan\Acl\Models
 */
class Permission extends Model
{

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Relation to roles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    /**
     * Relation to users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @throws
     */
    public function users()
    {
        $userClass = config('auth.providers.users.model');

        if (! class_exists($userClass)) {
            throw new Exception("User class {$userClass} not found!", 1);
        }

        return $this->belongsToMany($userClass, 'users_permissions');
    }

}
