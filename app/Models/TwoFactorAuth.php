<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactorAuth extends Model
{
    protected $fillable = [
        'user_id', 'secret', 'is_enabled'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
