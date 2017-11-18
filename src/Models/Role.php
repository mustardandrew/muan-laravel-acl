<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Muan\Acl
 * @subpackage Models
 */
class Role extends Model
{
    protected $fillable = [
        'title'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'roles_permissions');
    }
}
