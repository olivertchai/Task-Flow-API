<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    protected $fillable = [
            'id',
            'user_id',
            'name',
            'description',
            'status',
            'deadline',
            'created_at',
            'updated_at'
        ];

    public function isAvailable() {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS
        ]);
    }
    
}
