<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const CLOSED_PROJECT_STATUSES = [
        'complete',
        'abandoned',
    ];

    const IN_PROGRESS_PROJECT_STATUSES = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];


    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function currentStatus()
    {
        return $this->morphOne(CurrentStatus::class, 'attached')->orderBy('created_at', 'DESC');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function incompleteTasks()
    {
        return $this->tasks()->whereNull('completed_date');
    }

    public function pastDueTasks()
    {
        return $this->incompleteTasks()->whereNotNull('due_date')->where('due_date', '<', date('Y-m-d'));
    }

    public function tasksAssignedToUser($userId = null)
    {
        $userId = $userId ?? auth()->user()->id;

        return $this->tasks()->where('assigned_to', $userId);
    }

    public function incompleteUserTasks($userId = null)
    {
        return $this->tasksAssignedToUser($userId)->whereNull('completed_date');
    }

    public function scopeAddTaskCounts($q)
    {
        return $q->withCount(['pastDueTasks', 'incompleteTasks', 'incompleteUserTasks']);
    }

    public function scopeWithOpenTasks($q)
    {
        return $q->whereHas('incompleteTasks');
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class);
    }

    public function scopeForUser($q, $user)
    {
        $user = $user instanceof User ? $user->id : $user;

        return $q->whereHas('tasks', function($tq) use($user) {
            return $tq->where('assigned_to', $user);
        });
    }

    public function getIsCompleteAttribute()
    {
        return !empty($this->completed_date);
    }

    public function getIsLateAttribute()
    {
        if(empty($this->due_date)) {
            return false;
        }

        return $this->due_date->isPast();
    }
}
