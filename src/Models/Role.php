<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;

use Muan\Acl\Traits\HasPermissions;

/**
 * Class Role
 * @package Muan\Acl
 * @subpackage Models
 */
class Role extends Model
{
    use HasPermissions;

    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'roles_permissions');
    }
}
