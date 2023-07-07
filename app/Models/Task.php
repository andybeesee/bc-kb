<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'attached');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getIsCompleteAttribute()
    {
        return !empty($this->completed_date);
    }

    public function getIsLateAttribute()
    {
        if(empty($this->due_date) || $this->getIsCompleteAttribute()) {
            return false;
        }

        return $this->due_date->isPast();
    }

    public function scopeIncomplete($q)
    {
        return $q->where(function($eq) {
            $eq->whereNull('completed_date')
                // only use in progress projects - more to do on this later?
                ->whereHas('project', function($pq) {
                    return $pq->whereIn('projects.status', Project::IN_PROGRESS_PROJECT_STATUSES);
                });
        });
    }
}
