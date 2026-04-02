<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model{
    protected $fillable = [
        'id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];
    // RELACIONAMENTOS
    public function project(){
        // Uma tarefa PERTENCE A um projeto        
        return $this->belongsTo(Project::class);
    }

    public function tags(){
        // Uma tarefa TEM MUITAS tags
        return $this->belongsToMany(Tag::class);
    }

}
