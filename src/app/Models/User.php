<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

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
        'verification_token',
    ];

    public static function generateVerificationToken()
    {
        return str()->random(40); // Gera um token aleatório de 40 caracteres
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Adicionando os casts conforme pede o Módulo 4.6
            'verified' => 'boolean',
            'admin' => 'boolean',
        ];
    }

    public function isVerified() {
        return $this->verified == self::VERIFIED_USER;
    }

    public function isAdmin() {
        return $this->admin == self::ADMIN_USER;
    }

    public static function generateVerificationCode() {
        return Str::random(40);
    }

    // RELACIONAMENTOS
    public function projects(){
        // Um usuário TEM MUITOS projetos
        return $this->hasMany(Project::class);
    }

    public function profile(){
        // Um usuário TEM UM perfil
        return $this->hasOne(Profile::class);
    }
}
