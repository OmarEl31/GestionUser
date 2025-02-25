<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'activity', 'created_at'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
