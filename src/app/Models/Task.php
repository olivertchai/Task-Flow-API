<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    protected $fillable = [
        'id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function isAvailable():bool {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS
        ],true);
    }

    public function isImportant(): bool{
        return in_array($this->priority, [
            self::PRIORITY_HIGH,
            self::PRIORITY_MEDIUM
        ],true);
    }

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
