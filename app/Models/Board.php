<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
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
}
