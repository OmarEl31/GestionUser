<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;


class Role extends Model
{
    protected $fillable = [
        'role_name', 'role_description'
    ];

    // Relations
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
