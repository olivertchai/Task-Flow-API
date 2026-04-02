<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tag extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'color',
        'created_at',
    ];

    public function tasks(){
        // Uma tag PERTENCE A MUITAS tarefas
        return $this->belongsToMany(Task::class);
    }
}
