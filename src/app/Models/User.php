<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Essencial para o middleware auth:sanctum

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Constantes para manter o código limpo
    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified' => 'boolean',
            'admin' => 'boolean',
        ];
    }

    // Métodos de ajuda (Helpers)
    public function isVerified() {
        return $this->verified == self::VERIFIED_USER;
    }

    public function isAdmin() {
        return $this->admin == self::ADMIN_USER;
    }

    // RELACIONAMENTOS
    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }
}