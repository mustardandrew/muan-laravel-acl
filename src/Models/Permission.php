<?php

namespace Muan\Acl\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permision
 * @package Muan\Acl
 * @subpackage Models
 */
class Permision extends Model
{
    protected $fillable = [
        'title'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
