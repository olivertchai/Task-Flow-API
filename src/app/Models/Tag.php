<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
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
