<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'bio',
        'avatar',
        'phone',
        'avatar_url',
        'created_at',
    ];

    // RELACIONAMENTOS
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
