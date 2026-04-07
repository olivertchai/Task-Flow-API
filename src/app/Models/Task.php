<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
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
