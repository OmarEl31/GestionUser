<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'permission_name', 'permission_description'
    ];

    // Relations
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
