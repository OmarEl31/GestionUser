<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, \OwenIt\Auditing\Auditable, Impersonate, LogsActivity;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    // Relations
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function twoFactorAuth()
    {
        return $this->hasOne(TwoFactorAuth::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('user_activity')
            ->logOnlyDirty();
    }
    // Permissions par rôle
    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }
}
