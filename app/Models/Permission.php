<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class CustomPermission extends Model
{
    protected $fillable = [
        'permission_name', 'permission_description'
    ];

    // Relations
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'custom_permission_role');
    }
}
