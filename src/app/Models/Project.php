<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Project extends Model{ 
    /** @use HasFactory<UserFactory> */
    use HasFactory;   
    protected $fillable = [
            'user_id',
            'name',
            'description',
            'status',
            'deadline',
        ];

    // RELACIONAMENTOS
    public function tasks(){
        // Um projeto TEM MUITAS tarefas
        return $this->hasMany(Task::class);
    }

    public function user(){
        // Um projeto PERTENCE A um usuário
        return $this->belongsTo(User::class);
    }
}
