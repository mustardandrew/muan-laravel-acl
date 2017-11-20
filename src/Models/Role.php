<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;

use Muan\Acl\Traits\HasPermissionsTrait;

/**
 * Class Role
 * @package Muan\Acl
 * @subpackage Models
 */
class Role extends Model
{
    use HasPermissionsTrait;

    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'roles_permissions');
    }
}
