<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Profile extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
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
