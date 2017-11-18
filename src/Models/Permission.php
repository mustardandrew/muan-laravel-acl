<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package Muan\Acl
 * @subpackage Models
 */
class Permission extends Model
{
    protected $fillable = [
        'name'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
